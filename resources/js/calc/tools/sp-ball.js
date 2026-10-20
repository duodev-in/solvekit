import { defineTools } from '../engines/formula.js';
import { handlersFor, num } from '../physics/core.js';

/**
 * Ball sports statistics: baseball, basketball, cricket and team-sport rates, from each sport's official definitions.
 */

/** Innings pitched as written in a box score: 6.1 is 6⅓ and 6.2 is 6⅔. */
export function innings(ip) {
    const whole = Math.trunc(ip);
    const outs = Math.round((ip - whole) * 10);

    return outs >= 0 && outs <= 2 ? whole + outs / 3 : NaN;
}

/** Overs as written in cricket: 12.3 is 12 overs and 3 balls (12½ overs). */
export function overs(o) {
    const whole = Math.trunc(o);
    const balls = Math.round((o - whole) * 10);

    return balls >= 0 && balls <= 5 ? whole + balls / 6 : NaN;
}

/** Baseball rate text: .300, 1.050. */
export const rate = (x, places = 3) => {
    const t = x.toFixed(places);

    return Math.abs(x) < 1 ? t.replace(/^(-?)0\./, '$1.') : t;
};
const N = (label, value, min = 0) => [label, null, null, value, min];
const ipError = 'Innings pitched must end in .0, .1 or .2 (one decimal per out).';
const overError = 'Overs must end in .0 to .5 (balls in the over).';
const band = (x, bands) => bands.find(([limit]) => x >= limit)?.[1] ?? bands[bands.length - 1][1];

export const TOOLS = {
    // Baseball -----------------------------------------------------------------------------------
    batting_average: {
        type: 'calc',
        inputs: { H: N('Hits', 150), AB: N('At-bats', 500, 1), target: N('Target average (optional)', 0.3) },
        optional: ['target'],
        label: 'Batting average',
        rows: { pct: 'As a percentage', need: 'Hits for the target (same at-bats)', band: 'Rating' },
        run: (x) => {
            if (x.H > x.AB) {
                return { error: 'Hits cannot exceed at-bats.' };
            }

            const avg = x.H / x.AB;

            return { value: rate(avg), sub: `${num(x.H)} hits in ${num(x.AB)} at-bats`, rows: { pct: `${num(avg * 100, 4)}%`, need: Number.isFinite(x.target) ? `${Math.ceil(x.target * x.AB - 1e-9)} hits (${Math.max(0, Math.ceil(x.target * x.AB - 1e-9) - x.H)} more)` : 'Enter a target', band: band(avg, [[0.3, 'Excellent (.300 or better)'], [0.27, 'Above average'], [0.25, 'About league average'], [0.23, 'Below average'], [0, 'Poor']]) }, steps: ['AVG = H ÷ AB (MLB Official Baseball Rules 9.22)', `= ${num(x.H)} ÷ ${num(x.AB)} = ${rate(avg)}`] };
        },
    },
    era: {
        type: 'calc',
        inputs: { ER: N('Earned runs', 60), IP: N('Innings pitched (6.1 = 6⅓)', 180), G: N('Innings in a game', 9, 1) },
        label: 'Earned run average',
        rows: { ip: 'Innings as a number', band: 'Rating (9-inning games)' },
        run: (x) => {
            const ip = innings(x.IP);

            if (!(ip > 0)) {
                return { error: ipError };
            }

            const era = (x.G * x.ER) / ip;

            return { value: era.toFixed(2), sub: `${num(x.ER)} earned runs in ${num(ip, 5)} innings`, rows: { ip: num(ip, 6), band: band(-era, [[-2.5, 'Elite (under 2.50)'], [-3.25, 'Very good'], [-4, 'Above average'], [-4.75, 'About average'], [-1e9, 'Below average']]) }, steps: ['ERA = innings per game × ER ÷ IP', `= ${num(x.G)} × ${num(x.ER)} ÷ ${num(ip, 6)} = ${era.toFixed(3)}`] };
        },
    },
    fielding_pct: {
        type: 'calc',
        inputs: { PO: N('Putouts', 300), A: N('Assists', 120), E: N('Errors', 8) },
        label: 'Fielding percentage',
        rows: { tc: 'Total chances' },
        run: (x) => {
            const tc = x.PO + x.A + x.E;

            if (!(tc > 0)) {
                return { error: 'Enter at least one chance.' };
            }

            return { value: rate((x.PO + x.A) / tc), sub: `${num(tc)} total chances`, rows: { tc: num(tc) }, steps: ['FPCT = (PO + A) ÷ (PO + A + E)', `= ${num(x.PO + x.A)} ÷ ${num(tc)} = ${rate((x.PO + x.A) / tc, 4)}`] };
        },
    },
    fip: {
        type: 'calc',
        inputs: { HR: N('Home runs allowed', 20), BB: N('Walks', 50), HBP: N('Hit batters', 6), K: N('Strikeouts', 200), IP: N('Innings pitched (6.1 = 6⅓)', 190), C: ['FIP constant (season value; about 3.1–3.2)', null, null, 3.1], ERA: N('ERA (optional, to compare)', 3.4) },
        optional: ['ERA'],
        label: 'FIP',
        rows: { core: 'Before the constant', vs: 'Compared with ERA' },
        run: (x) => {
            const ip = innings(x.IP);

            if (!(ip > 0)) {
                return { error: ipError };
            }

            const core = (13 * x.HR + 3 * (x.BB + x.HBP) - 2 * x.K) / ip;
            const fip = core + x.C;

            return { value: fip.toFixed(2), sub: 'Fielding Independent Pitching (FanGraphs)', rows: { core: num(core, 4), vs: Number.isFinite(x.ERA) ? `ERA − FIP = ${(x.ERA - fip).toFixed(2)} (${x.ERA > fip ? 'ERA likely to fall' : 'ERA likely to rise'})` : 'Enter an ERA' }, steps: ['FIP = (13 HR + 3(BB + HBP) − 2 K) ÷ IP + constant', `= (${13 * x.HR} + ${3 * (x.BB + x.HBP)} − ${2 * x.K}) ÷ ${num(ip, 6)} + ${num(x.C)} = ${fip.toFixed(3)}`, 'The constant puts FIP on the ERA scale; FanGraphs publishes it each season'] };
        },
    },
    magic_number: {
        type: 'calc',
        inputs: { G: N('Games in the season', 162, 1), W: N('Leader’s wins', 90), L2: N('Second team’s losses', 60) },
        label: 'Magic number',
        rows: { tragic: 'Meaning', clinched: 'Status' },
        run: (x) => {
            const mn = x.G + 1 - x.W - x.L2;

            return { value: num(Math.max(0, mn)), sub: 'Leader wins plus second-place losses needed to clinch', rows: { tragic: 'Each leader win or second-place loss lowers it by one', clinched: mn <= 0 ? 'Clinched' : `${num(mn)} to go` }, steps: ['Magic number = G + 1 − W(leader) − L(second)', `= ${num(x.G)} + 1 − ${num(x.W)} − ${num(x.L2)} = ${num(mn)}`] };
        },
    },
    obp: {
        type: 'calc',
        inputs: { H: N('Hits', 150), BB: N('Walks', 70), HBP: N('Hit by pitch', 5), AB: N('At-bats', 500, 1), SF: N('Sacrifice flies', 5) },
        label: 'On-base percentage',
        rows: { tob: 'Times on base', pa: 'Plate appearances counted' },
        run: (x) => {
            const tob = x.H + x.BB + x.HBP;
            const d = x.AB + x.BB + x.HBP + x.SF;

            return { value: rate(tob / d), sub: `${num(tob)} times on base`, rows: { tob: num(tob), pa: num(d) }, steps: ['OBP = (H + BB + HBP) ÷ (AB + BB + HBP + SF)', `= ${num(tob)} ÷ ${num(d)} = ${rate(tob / d, 4)}`] };
        },
    },
    ops: {
        type: 'calc',
        inputs: { s1: N('Singles', 100), s2: N('Doubles', 30), s3: N('Triples', 3), HR: N('Home runs', 25), BB: N('Walks', 70), HBP: N('Hit by pitch', 5), AB: N('At-bats', 550, 1), SF: N('Sacrifice flies', 5) },
        label: 'OPS',
        rows: { obp: 'On-base percentage', slg: 'Slugging percentage', band: 'Rating' },
        run: (x) => {
            const H = x.s1 + x.s2 + x.s3 + x.HR;
            const obp = (H + x.BB + x.HBP) / (x.AB + x.BB + x.HBP + x.SF);
            const slg = (x.s1 + 2 * x.s2 + 3 * x.s3 + 4 * x.HR) / x.AB;

            return { value: rate(obp + slg), sub: `OBP ${rate(obp)} + SLG ${rate(slg)}`, rows: { obp: rate(obp), slg: rate(slg), band: band(obp + slg, [[0.9, 'Excellent (.900+)'], [0.833, 'Very good'], [0.766, 'Above average'], [0.7, 'Average'], [0, 'Below average']]) }, steps: ['OPS = OBP + SLG', `OBP = (H + BB + HBP) ÷ (AB + BB + HBP + SF) = ${rate(obp, 4)}`, `SLG = TB ÷ AB = ${rate(slg, 4)}`] };
        },
    },
    slugging: {
        type: 'calc',
        inputs: { s1: N('Singles', 100), s2: N('Doubles', 30), s3: N('Triples', 3), HR: N('Home runs', 25), AB: N('At-bats', 550, 1) },
        label: 'Slugging percentage',
        rows: { tb: 'Total bases', iso: 'Isolated power (SLG − AVG)', avg: 'Batting average' },
        run: (x) => {
            const tb = x.s1 + 2 * x.s2 + 3 * x.s3 + 4 * x.HR;
            const H = x.s1 + x.s2 + x.s3 + x.HR;

            if (H > x.AB) {
                return { error: 'Hits cannot exceed at-bats.' };
            }

            return { value: rate(tb / x.AB), sub: `${num(tb)} total bases`, rows: { tb: num(tb), iso: rate(tb / x.AB - H / x.AB), avg: rate(H / x.AB) }, steps: ['SLG = (1B + 2·2B + 3·3B + 4·HR) ÷ AB', `= ${num(tb)} ÷ ${num(x.AB)} = ${rate(tb / x.AB, 4)}`] };
        },
    },
    war: {
        type: 'calc',
        inputs: { bat: ['Batting runs', null, null, 25], br: ['Base-running runs', null, null, 2], fld: ['Fielding runs', null, null, 5], pos: ['Positional adjustment (runs)', null, null, 2.5], lg: ['League adjustment (runs)', null, null, 1], rep: ['Replacement-level runs', null, null, 20], rpw: N('Runs per win', 9.8, 1) },
        label: 'WAR',
        rows: { rar: 'Runs above replacement', band: 'Rating' },
        run: (x) => {
            const rar = x.bat + x.br + x.fld + x.pos + x.lg + x.rep;
            const war = rar / x.rpw;

            return { value: war.toFixed(1), sub: 'Position-player WAR from your component runs (FanGraphs framework)', rows: { rar: num(rar, 4), band: band(war, [[8, 'MVP level'], [5, 'All-Star'], [3, 'Good regular'], [2, 'Starter'], [0, 'Bench or replacement']]) }, steps: ['WAR = (batting + base running + fielding + positional + league + replacement runs) ÷ runs per win', `= ${num(rar)} ÷ ${num(x.rpw)} = ${war.toFixed(2)}`, 'Component runs come from a stats site; this does not compute them from raw stats'] };
        },
    },
    whip: {
        type: 'calc',
        inputs: { BB: N('Walks', 45), H: N('Hits allowed', 160), IP: N('Innings pitched (6.1 = 6⅓)', 180) },
        label: 'WHIP',
        rows: { band: 'Rating' },
        run: (x) => {
            const ip = innings(x.IP);

            if (!(ip > 0)) {
                return { error: ipError };
            }

            const w = (x.BB + x.H) / ip;

            return { value: w.toFixed(2), sub: 'Walks plus hits per inning pitched', rows: { band: band(-w, [[-1, 'Excellent (under 1.00)'], [-1.2, 'Very good'], [-1.3, 'Above average'], [-1.4, 'Average'], [-1e9, 'Below average']]) }, steps: ['WHIP = (BB + H) ÷ IP', `= ${num(x.BB + x.H)} ÷ ${num(ip, 6)} = ${w.toFixed(3)}`] };
        },
    },
    babip: {
        type: 'calc',
        inputs: { H: N('Hits', 150), HR: N('Home runs', 25), AB: N('At-bats', 550, 1), K: N('Strikeouts', 120), SF: N('Sacrifice flies', 5) },
        label: 'BABIP',
        rows: { bip: 'Balls in play', note: 'Context' },
        run: (x) => {
            const bip = x.AB - x.K - x.HR + x.SF;

            return { value: rate((x.H - x.HR) / bip), sub: `${num(bip)} balls in play`, rows: { bip: num(bip), note: 'League BABIP is usually close to .300; large gaps often regress' }, steps: ['BABIP = (H − HR) ÷ (AB − K − HR + SF)', `= ${num(x.H - x.HR)} ÷ ${num(bip)} = ${rate((x.H - x.HR) / bip, 4)}`] };
        },
    },
    pythagorean: {
        type: 'calc',
        inputs: { RS: N('Runs scored', 800), RA: N('Runs allowed', 700), G: N('Games', 162, 1), W: N('Actual wins (optional)', 92), exp: N('Exponent', 1.83, 0.5) },
        optional: ['W'],
        label: 'Expected winning percentage',
        rows: { wins: 'Expected wins', luck: 'Actual minus expected' },
        run: (x) => {
            const p = x.RS ** x.exp / (x.RS ** x.exp + x.RA ** x.exp);

            return { value: rate(p), sub: `${num(p * x.G, 4)} expected wins`, rows: { wins: num(p * x.G, 4), luck: Number.isFinite(x.W) ? `${num(x.W - p * x.G, 3)} wins` : 'Enter actual wins' }, steps: ['Win% = RS^x ÷ (RS^x + RA^x) (Bill James; x = 2 originally, 1.83 fits better)', `= ${rate(p, 4)}`] };
        },
    },
    k9: {
        type: 'calc',
        inputs: { K: N('Strikeouts', 200), BB: N('Walks', 50), IP: N('Innings pitched (6.1 = 6⅓)', 190) },
        label: 'Strikeouts per nine (K/9)',
        rows: { bb9: 'Walks per nine (BB/9)', kbb: 'Strikeout-to-walk ratio' },
        run: (x) => {
            const ip = innings(x.IP);

            if (!(ip > 0)) {
                return { error: ipError };
            }

            return { value: ((9 * x.K) / ip).toFixed(2), sub: `BB/9 ${((9 * x.BB) / ip).toFixed(2)}`, rows: { bb9: ((9 * x.BB) / ip).toFixed(2), kbb: x.BB > 0 ? (x.K / x.BB).toFixed(2) : 'No walks' }, steps: ['K/9 = 9 × K ÷ IP, BB/9 = 9 × BB ÷ IP', `= 9 × ${num(x.K)} ÷ ${num(ip, 6)}`] };
        },
    },

    // Basketball ---------------------------------------------------------------------------------
    efg: {
        type: 'calc',
        inputs: { FG: N('Field goals made', 8), P3: N('Three-pointers made', 3), FGA: N('Field-goal attempts', 15, 1) },
        label: 'Effective field-goal percentage',
        rows: { fg: 'Plain FG%', boost: 'Added by three-pointers' },
        run: (x) => {
            if (x.P3 > x.FG || x.FG > x.FGA) {
                return { error: 'Threes made ≤ field goals made ≤ attempts.' };
            }

            const e = (x.FG + 0.5 * x.P3) / x.FGA;

            return { value: `${num(e * 100, 4)}%`, sub: 'A made three counts 1.5 field goals', rows: { fg: `${num((x.FG / x.FGA) * 100, 4)}%`, boost: `${num((e - x.FG / x.FGA) * 100, 3)} points` }, steps: ['eFG% = (FG + 0.5 × 3P) ÷ FGA', `= (${num(x.FG)} + ${num(0.5 * x.P3)}) ÷ ${num(x.FGA)} = ${num(e * 100)}%`] };
        },
    },
    game_score: {
        type: 'calc',
        inputs: { PTS: N('Points', 25), FG: N('Field goals made', 9), FGA: N('Field-goal attempts', 18), FT: N('Free throws made', 5), FTA: N('Free-throw attempts', 6), ORB: N('Offensive rebounds', 2), DRB: N('Defensive rebounds', 6), STL: N('Steals', 2), AST: N('Assists', 5), BLK: N('Blocks', 1), PF: N('Personal fouls', 3), TOV: N('Turnovers', 3) },
        label: 'Game Score',
        rows: { band: 'Rating' },
        run: (x) => {
            const gs = x.PTS + 0.4 * x.FG - 0.7 * x.FGA - 0.4 * (x.FTA - x.FT) + 0.7 * x.ORB + 0.3 * x.DRB + x.STL + 0.7 * x.AST + 0.7 * x.BLK - 0.4 * x.PF - x.TOV;

            return { value: gs.toFixed(1), sub: 'John Hollinger’s Game Score', rows: { band: band(gs, [[40, 'Outstanding'], [30, 'Great'], [20, 'Very good'], [10, 'Average'], [-1e9, 'Poor']]) }, steps: ['GmSc = PTS + 0.4FG − 0.7FGA − 0.4(FTA − FT) + 0.7ORB + 0.3DRB + STL + 0.7AST + 0.7BLK − 0.4PF − TOV', `= ${gs.toFixed(2)}`] };
        },
    },
    ts: {
        type: 'calc',
        inputs: { PTS: N('Points', 25), FGA: N('Field-goal attempts', 18), FTA: N('Free-throw attempts', 6) },
        label: 'True shooting percentage',
        rows: { tsa: 'True shooting attempts', band: 'Rating' },
        run: (x) => {
            const tsa = x.FGA + 0.44 * x.FTA;
            const t = x.PTS / (2 * tsa);

            if (!(tsa > 0)) {
                return { error: 'Enter some shot attempts.' };
            }

            return { value: `${num(t * 100, 4)}%`, sub: 'Counts twos, threes and free throws', rows: { tsa: num(tsa, 4), band: band(t, [[0.62, 'Excellent'], [0.58, 'Above average'], [0.54, 'About league average'], [0, 'Below average']]) }, steps: ['TS% = PTS ÷ (2 × (FGA + 0.44 × FTA))', `= ${num(x.PTS)} ÷ (2 × ${num(tsa)}) = ${num(t * 100)}%`] };
        },
    },
    usage: {
        type: 'calc',
        inputs: { FGA: N('Player FGA', 18), FTA: N('Player FTA', 6), TOV: N('Player turnovers', 3), MP: N('Player minutes', 36, 1), tFGA: N('Team FGA', 88, 1), tFTA: N('Team FTA', 22), tTOV: N('Team turnovers', 13), tMP: N('Team minutes (240 for regulation)', 240, 1) },
        label: 'Usage rate',
        rows: { band: 'Context' },
        run: (x) => {
            const u = (100 * (x.FGA + 0.44 * x.FTA + x.TOV) * (x.tMP / 5)) / (x.MP * (x.tFGA + 0.44 * x.tFTA + x.tTOV));

            return { value: `${num(u, 4)}%`, sub: 'Share of team plays used while on the floor', rows: { band: u >= 30 ? 'Star usage (30%+)' : u >= 24 ? 'High' : u >= 18 ? 'Average (about 20%)' : 'Low' }, steps: ['USG% = 100 × (FGA + 0.44FTA + TOV) × (Team MP ÷ 5) ÷ (MP × (Team FGA + 0.44 Team FTA + Team TOV))', `= ${num(u)}%`] };
        },
    },
    ast_to: {
        type: 'calc',
        inputs: { AST: N('Assists', 8), TOV: N('Turnovers', 3) },
        label: 'Assist-to-turnover ratio',
        rows: { band: 'Rating' },
        run: (x) => (x.TOV > 0 ? { value: (x.AST / x.TOV).toFixed(2), sub: `${num(x.AST)} assists, ${num(x.TOV)} turnovers`, rows: { band: band(x.AST / x.TOV, [[3, 'Elite (3+)'], [2, 'Good'], [1.5, 'Average'], [0, 'Below average']]) }, steps: ['AST/TO = assists ÷ turnovers', `= ${num(x.AST)} ÷ ${num(x.TOV)} = ${(x.AST / x.TOV).toFixed(3)}`] } : { error: 'With no turnovers the ratio is undefined.' }),
    },
    dunk: {
        type: 'calc',
        inputs: { reach: ['Standing reach', 'length', 'cm', 230], jump: ['Vertical jump', 'length', 'cm', 70], rim: ['Rim height', 'length', 'cm', 304.8], hand: ['Reach needed above the rim', 'select', { 15: 'About 15 cm (large hands, palming the ball)', 25: 'About 25 cm (two hands or small hands)' }, '15'] },
        out: 'length',
        outUnit: 'cm',
        label: 'Your reach above the rim',
        rows: { can: 'Can you dunk?', need: ['Vertical jump needed', 'length'], hang: 'Hang time at that jump' },
        run: (x) => {
            const top = x.reach + x.jump - x.rim;
            const need = x.rim + Number(x.hand) / 100 - x.reach;

            return { value: top, sub: top >= Number(x.hand) / 100 ? 'Enough to dunk' : `${num((Number(x.hand) / 100 - top) * 100, 3)} cm short`, rows: { can: top >= Number(x.hand) / 100 ? 'Yes' : 'Not yet', need: [Math.max(0, need), 'length'], hang: `${num(Math.sqrt((8 * x.jump) / 9.80665), 3)} s` }, steps: ['Top of reach = standing reach + vertical jump', `= ${num(x.reach * 100)} + ${num(x.jump * 100)} cm; rim ${num(x.rim * 100)} cm`, 'Hang time t = √(8h ÷ g)', 'A rule of thumb: the ball needs a hand roughly 15–25 cm above the rim'] };
        },
    },

    // Cricket ------------------------------------------------------------------------------------
    strike_rate: {
        type: 'calc',
        inputs: { R: N('Runs', 85), B: N('Balls faced', 60, 1) },
        label: 'Batting strike rate',
        rows: { rpo: 'Runs per over', band: 'Context' },
        run: (x) => ({ value: ((100 * x.R) / x.B).toFixed(2), sub: 'Runs per 100 balls', rows: { rpo: ((6 * x.R) / x.B).toFixed(2), band: (100 * x.R) / x.B >= 150 ? 'Explosive (T20 level)' : (100 * x.R) / x.B >= 100 ? 'Fast (ODI level)' : 'Steady' }, steps: ['SR = 100 × runs ÷ balls', `= 100 × ${num(x.R)} ÷ ${num(x.B)} = ${((100 * x.R) / x.B).toFixed(3)}`] }),
    },
    bowling_average: {
        type: 'calc',
        inputs: { R: N('Runs conceded', 450), W: N('Wickets', 20, 1), O: N('Overs bowled (optional; 12.3 = 12½)', 150) },
        optional: ['O'],
        label: 'Bowling average',
        rows: { sr: 'Bowling strike rate (balls per wicket)', econ: 'Economy rate' },
        run: (x) => {
            const o = Number.isFinite(x.O) ? overs(x.O) : NaN;

            if (Number.isFinite(x.O) && !Number.isFinite(o)) {
                return { error: overError };
            }

            return { value: (x.R / x.W).toFixed(2), sub: 'Runs conceded per wicket', rows: { sr: Number.isFinite(o) ? ((o * 6) / x.W).toFixed(1) : 'Enter overs', econ: Number.isFinite(o) ? (x.R / o).toFixed(2) : 'Enter overs' }, steps: ['Average = runs ÷ wickets', `= ${num(x.R)} ÷ ${num(x.W)} = ${(x.R / x.W).toFixed(3)}`] };
        },
    },
    follow_on: {
        type: 'calc',
        inputs: { days: ['Match length', 'select', { 5: 'Five days or more (Tests)', 3: 'Three or four days', 2: 'Two days', 1: 'One day' }, '5'], first: N('First-innings score of the team batting first', 450), second: N('First-innings score of the other team', 230) },
        label: 'Can the follow-on be enforced?',
        rows: { lead: 'First-innings lead', needed: 'Lead needed', avoid: 'Runs the second team needed to avoid it' },
        run: (x) => {
            const need = { 5: 200, 3: 150, 2: 100, 1: 75 }[x.days];
            const lead = x.first - x.second;

            return { value: lead >= need ? 'Yes' : 'No', sub: `Lead ${num(lead)} runs; needs ${need}`, rows: { lead: `${num(lead)} runs`, needed: `${need} runs`, avoid: `${num(x.first - need + 1)} (they made ${num(x.second)})` }, steps: [`MCC Law 14.1: the side batting first may enforce the follow-on with a lead of at least ${need} runs in a match of this length`, 'The captain may choose not to enforce it'] };
        },
    },
    icc_rating: {
        type: 'calc',
        inputs: { ra: N('Team A rating', 115), rb: N('Team B rating', 105), result: ['Result', 'select', { a: 'Team A won', b: 'Team B won', tie: 'Tie or no result with a result decided' }, 'a'] },
        label: 'Points earned by team A',
        rows: { pb: 'Points earned by team B', gap: 'Rating gap', rule: 'Rule used' },
        run: (x) => {
            const gap = Math.abs(x.ra - x.rb);
            let pa;
            let pb;
            let rule;

            if (gap < 40) {
                rule = 'Gap under 40: winner gets opponent’s rating + 50, loser gets opponent’s rating − 50';
                [pa, pb] = x.result === 'a' ? [x.rb + 50, x.ra - 50] : x.result === 'b' ? [x.rb - 50, x.ra + 50] : [x.rb, x.ra];
            } else {
                rule = 'Gap of 40 or more: stronger side gets own rating + 10 for a win, − 90 for a loss; weaker side the reverse; a tie moves both 40 towards each other';
                const aStrong = x.ra > x.rb;
                const win = (own) => own + 10;
                const lose = (own) => own - 90;

                if (x.result === 'tie') {
                    [pa, pb] = aStrong ? [x.ra - 40, x.rb + 40] : [x.ra + 40, x.rb - 40];
                } else if ((x.result === 'a') === aStrong) {
                    [pa, pb] = aStrong ? [win(x.ra), x.rb - 10] : [x.ra - 10, win(x.rb)];
                } else {
                    [pa, pb] = aStrong ? [lose(x.ra), x.rb + 90] : [x.ra + 90, lose(x.rb)];
                }
            }

            return { value: num(pa), sub: 'Rating points for this match (ICC ODI and T20I method)', rows: { pb: num(pb), gap: num(gap), rule }, steps: ['A team’s rating = total points ÷ matches (recent matches weighted)', rule, 'Add these points to each team’s total and one match to its count'] };
        },
    },
    nrr: {
        type: 'calc',
        inputs: { matches: ['Matches: runs for, overs faced, runs against, overs bowled (one match per line; all out = full quota)', 'textarea', null, '180, 20, 150, 20\n142, 18.4, 160, 20\n201, 20, 205, 19.5'] },
        label: 'Net run rate',
        rows: { rf: 'Run rate for', ra: 'Run rate against', totals: 'Totals' },
        run: (x) => {
            const rows = String(x.matches).split(/\n|;/).map((l) => l.trim()).filter(Boolean).map((l) => l.split(/[,\s]+/).map(Number));

            if (!rows.length || rows.some((r) => r.length !== 4 || !r.every(Number.isFinite))) {
                return { empty: 'Type each match as runs for, overs faced, runs against, overs bowled.' };
            }

            let [rf, of, ra, ob] = [0, 0, 0, 0];

            for (const [a, b, c, d] of rows) {
                const [o1, o2] = [overs(b), overs(d)];

                if (!Number.isFinite(o1) || !Number.isFinite(o2)) {
                    return { error: overError };
                }

                [rf, of, ra, ob] = [rf + a, of + o1, ra + c, ob + o2];
            }

            const nrr = rf / of - ra / ob;

            return { value: `${nrr >= 0 ? '+' : ''}${nrr.toFixed(3)}`, sub: `${rows.length} matches`, rows: { rf: (rf / of).toFixed(3), ra: (ra / ob).toFixed(3), totals: `${num(rf)} runs in ${num(of, 6)} overs; ${num(ra)} conceded in ${num(ob, 6)} overs` }, steps: ['NRR = runs for ÷ overs faced − runs against ÷ overs bowled (ICC Playing Conditions)', 'A side bowled out counts the full quota of overs', `= ${(rf / of).toFixed(4)} − ${(ra / ob).toFixed(4)} = ${nrr.toFixed(4)}`] };
        },
    },
    cricket_average: {
        type: 'calc',
        inputs: { R: N('Runs', 1200), I: N('Innings', 30, 1), NO: N('Not outs', 4) },
        label: 'Batting average',
        rows: { outs: 'Dismissals', perInn: 'Runs per innings' },
        run: (x) => {
            const outs = x.I - x.NO;

            return outs > 0 ? { value: (x.R / outs).toFixed(2), sub: `${num(outs)} dismissals`, rows: { outs: num(outs), perInn: (x.R / x.I).toFixed(2) }, steps: ['Average = runs ÷ (innings − not outs)', `= ${num(x.R)} ÷ ${num(outs)} = ${(x.R / outs).toFixed(3)}`] } : { error: 'No dismissals yet, so the average is undefined.' };
        },
    },
    economy: {
        type: 'calc',
        inputs: { R: N('Runs conceded', 38), O: N('Overs bowled (12.3 = 12½)', 10), W: N('Wickets (optional)', 2) },
        optional: ['W'],
        label: 'Economy rate',
        rows: { balls: 'Balls bowled', sr: 'Strike rate' },
        run: (x) => {
            const o = overs(x.O);

            if (!(o > 0)) {
                return { error: overError };
            }

            return { value: (x.R / o).toFixed(2), sub: 'Runs per over', rows: { balls: num(o * 6), sr: Number.isFinite(x.W) && x.W > 0 ? ((o * 6) / x.W).toFixed(1) : 'Enter wickets' }, steps: ['Economy = runs ÷ overs', `= ${num(x.R)} ÷ ${num(o, 6)} = ${(x.R / o).toFixed(3)}`] };
        },
    },
    required_rate: {
        type: 'calc',
        inputs: { target: N('Target', 280, 1), score: N('Current score', 150), left: N('Overs left (12.3 = 12½)', 20), done: N('Overs batted', 30) },
        label: 'Required run rate',
        rows: { needed: 'Runs needed', perBall: 'Runs per ball', current: 'Current run rate' },
        run: (x) => {
            const left = overs(x.left);
            const done = overs(x.done);

            if (!(left > 0) || !Number.isFinite(done)) {
                return { error: overError };
            }

            const need = x.target - x.score;

            return { value: (need / left).toFixed(2), sub: `${num(need)} runs from ${num(left * 6)} balls`, rows: { needed: num(need), perBall: (need / (left * 6)).toFixed(3), current: done > 0 ? (x.score / done).toFixed(2) : 'No overs yet' }, steps: ['RRR = runs needed ÷ overs left', `= ${num(need)} ÷ ${num(left, 6)} = ${(need / left).toFixed(3)}`] };
        },
    },

    // Team-sport rates ---------------------------------------------------------------------------
    goalie_save: {
        type: 'calc',
        inputs: { S: N('Saves', 30), GA: N('Goals against', 2) },
        label: 'Save percentage',
        rows: { shots: 'Shots on goal', band: 'Rating (ice hockey)' },
        run: (x) => {
            const sog = x.S + x.GA;

            return { value: rate(x.S / sog), sub: `${num(x.S)} saves from ${num(sog)} shots on goal`, rows: { shots: num(sog), band: band(x.S / sog, [[0.92, 'Excellent'], [0.91, 'Good (NHL average about .905)'], [0.9, 'Average'], [0, 'Below average']]) }, steps: ['SV% = saves ÷ shots on goal', `= ${num(x.S)} ÷ ${num(sog)} = ${rate(x.S / sog, 4)}`] };
        },
    },
    gaa: {
        type: 'calc',
        inputs: { GA: N('Goals against', 120), MIN: N('Minutes played', 3600, 1), len: ['Game length', 'select', { 60: '60 minutes (ice hockey)', 90: '90 minutes (football)', 48: '48 minutes', 32: '32 minutes (high school)' }, '60'] },
        label: 'Goals against average',
        rows: { games: 'Full games played' },
        run: (x) => ({ value: ((x.GA * Number(x.len)) / x.MIN).toFixed(2), sub: `Per ${x.len} minutes`, rows: { games: num(x.MIN / Number(x.len), 4) }, steps: ['GAA = goals against × game minutes ÷ minutes played', `= ${num(x.GA)} × ${x.len} ÷ ${num(x.MIN)} = ${((x.GA * Number(x.len)) / x.MIN).toFixed(3)}`] }),
    },
    passer_rating: {
        type: 'calc',
        inputs: { league: ['Formula', 'select', { nfl: 'NFL and CFL', ncaa: 'NCAA (college)' }, 'nfl'], C: N('Completions', 25), A: N('Attempts', 35, 1), Y: N('Passing yards', 300), TD: N('Touchdowns', 3), INT: N('Interceptions', 1) },
        label: 'Passer rating',
        rows: { parts: 'Components (each 0 to 2.375)', perfect: 'Scale' },
        run: (x) => {
            if (x.league === 'ncaa') {
                const r = (8.4 * x.Y + 330 * x.TD + 100 * x.C - 200 * x.INT) / x.A;

                return { value: r.toFixed(1), sub: 'NCAA passing efficiency', rows: { parts: 'Not used in the NCAA formula', perfect: 'Ranges from −731.6 to 1,261.6' }, steps: ['Rating = (8.4 Y + 330 TD + 100 C − 200 INT) ÷ A', `= ${r.toFixed(2)}`] };
            }

            const clamp = (v) => Math.min(2.375, Math.max(0, v));
            const a = clamp((x.C / x.A - 0.3) * 5);
            const b = clamp((x.Y / x.A - 3) * 0.25);
            const c = clamp((x.TD / x.A) * 20);
            const d = clamp(2.375 - (x.INT / x.A) * 25);
            const r = ((a + b + c + d) / 6) * 100;

            return { value: r.toFixed(1), sub: 'NFL passer rating', rows: { parts: `${a.toFixed(3)}, ${b.toFixed(3)}, ${c.toFixed(3)}, ${d.toFixed(3)}`, perfect: '0 to 158.3 (a perfect rating)' }, steps: ['a = (C/A − 0.3) × 5, b = (Y/A − 3) × 0.25, c = TD/A × 20, d = 2.375 − INT/A × 25, each kept between 0 and 2.375', `Rating = (a + b + c + d) ÷ 6 × 100 = ${r.toFixed(2)}`] };
        },
    },
    save_pct: {
        type: 'calc',
        inputs: { SV: N('Saves', 35), BS: N('Blown saves', 5) },
        label: 'Save percentage',
        rows: { opp: 'Save opportunities' },
        run: (x) => ({ value: `${num((x.SV / (x.SV + x.BS)) * 100, 4)}%`, sub: 'Baseball relief pitcher saves converted', rows: { opp: num(x.SV + x.BS) }, steps: ['SV% = SV ÷ (SV + BS)', `= ${num(x.SV)} ÷ ${num(x.SV + x.BS)}`] }),
    },
    win_pct: {
        type: 'calc',
        inputs: { W: N('Wins', 50), L: N('Losses', 30), T: N('Ties (or draws)', 2), lw: N('Leader’s wins (optional)', 55), ll: N('Leader’s losses (optional)', 27) },
        optional: ['lw', 'll'],
        label: 'Winning percentage',
        rows: { games: 'Games played', gb: 'Games behind the leader' },
        run: (x) => {
            const g = x.W + x.L + x.T;
            const p = (x.W + 0.5 * x.T) / g;

            return { value: rate(p), sub: `${num(p * 100, 4)}%`, rows: { games: num(g), gb: Number.isFinite(x.lw) && Number.isFinite(x.ll) ? num((x.lw - x.W + (x.L - x.ll)) / 2, 3) : 'Enter the leader’s record' }, steps: ['Win% = (W + 0.5 T) ÷ G (ties count half; some leagues ignore them)', `= (${num(x.W)} + ${num(0.5 * x.T)}) ÷ ${num(g)} = ${rate(p, 4)}`, 'Games behind = ((leader W − W) + (L − leader L)) ÷ 2'] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
