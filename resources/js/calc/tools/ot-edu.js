import { defineTools } from '../engines/formula.js';
import { handlersFor } from '../physics/core.js';
import { N, SEL, TXT, LINE, num, pct } from '../statistics/common.js';
import { mean, parseNumbers, sd, sum } from '../statistics/data.js';
import { normCdf } from '../statistics/special.js';

/**
 * Education: GPA, grades, curves, test scores and school years. Official rules where they are published (IELTS
 * band rounding, ACT composite, HEC Pakistan scale, CBSE/VTU/Anna/Mumbai conversions, PTE–IELTS concordance);
 * otherwise the common US conventions, which schools adapt.
 */

const LETTER_POINTS = { 'A+': 4.0, A: 4.0, 'A-': 3.7, 'B+': 3.3, B: 3.0, 'B-': 2.7, 'C+': 2.3, C: 2.0, 'C-': 1.7, 'D+': 1.3, D: 1.0, 'D-': 0.7, F: 0, E: 0 };
const PERCENT_LETTER = [[97, 'A+'], [93, 'A'], [90, 'A-'], [87, 'B+'], [83, 'B'], [80, 'B-'], [77, 'C+'], [73, 'C'], [70, 'C-'], [67, 'D+'], [63, 'D'], [60, 'D-'], [0, 'F']];
export const letterFor = (p) => PERCENT_LETTER.find(([min]) => p >= min)[1];

/** Grade points for a letter, a percentage or a number of points. */
function points(token, scale = 4) {
    const t = String(token).trim().toUpperCase().replace('–', '-');

    if (t in LETTER_POINTS) {
        return scale === 4.3 && t === 'A+' ? 4.3 : LETTER_POINTS[t];
    }

    const v = Number(t.replace('%', ''));

    if (!Number.isFinite(v)) {
        return NaN;
    }

    return t.endsWith('%') || v > 5 ? LETTER_POINTS[letterFor(v)] : v;
}

/** Reads "name, grade, credits[, level]" lines (name optional). */
function readCourses(text, { level = false } = {}) {
    const out = [];

    for (const [index, line] of String(text ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean).entries()) {
        const parts = line.split(/\s*[,;\t]\s*/);
        const levelPart = level && /^(r|h|ap|ib|reg|regular|honors|honours)$/i.test(parts[parts.length - 1]) ? parts.pop() : null;

        if (parts.length < 2) {
            return { problem: `Line ${index + 1} needs a grade and credits, e.g. “Maths, A-, 3”.` };
        }

        const credits = Number(parts[parts.length - 1]);
        const grade = parts[parts.length - 2];
        const name = parts.length > 2 ? parts.slice(0, -2).join(', ') : `Course ${index + 1}`;

        if (!(credits >= 0)) {
            return { problem: `Line ${index + 1}: credits must be a number.` };
        }

        out.push({ name, grade, credits, level: (levelPart ?? 'r').toLowerCase() });
    }

    return out.length ? { courses: out } : { empty: 'Enter your courses, one per line.' };
}

/** IELTS overall band: mean rounded to the nearest half band, .25 and .75 rounding up (ielts.org). */
export function ieltsOverall(bands) {
    const m = mean(bands);
    const whole = Math.floor(m + 1e-9);
    const frac = m - whole;

    return frac < 0.25 - 1e-9 ? whole : frac < 0.75 - 1e-9 ? whole + 0.5 : whole + 1;
}

/** A table [[minRaw, band], …] lookup. */
const bandFor = (table, raw) => (table.find(([min]) => raw >= min) ?? [0, null])[1];

export const TOOLS = {
    act: {
        type: 'calc',
        inputs: { version: SEL('Test', { enhanced: 'Enhanced ACT (from 2025): English, Math, Reading', legacy: 'Legacy ACT (before 2025): with Science' }, 'enhanced'), english: N('English (1–36)', 27, 1), math: N('Math (1–36)', 25, 1), reading: N('Reading (1–36)', 29, 1), science: N('Science (1–36; optional on the enhanced ACT)', 24, 1) },
        optional: ['science'],
        label: 'Composite score',
        rows: { average: 'Exact average', stem: 'STEM score (Math and Science)', sections: 'Sections in the composite' },
        run: (x) => {
            const s = [x.english, x.math, x.reading];
            const hasSci = Number.isFinite(x.science);

            if (![...s, ...(hasSci ? [x.science] : [])].every((v) => Number.isInteger(v) && v >= 1 && v <= 36)) {
                return { error: 'Section scores are whole numbers from 1 to 36.' };
            }

            if (x.version === 'legacy' && !hasSci) {
                return { error: 'The legacy ACT composite includes Science.' };
            }

            const parts = x.version === 'legacy' ? [...s, x.science] : s;
            const avg = mean(parts);

            return { value: String(Math.floor(avg + 0.5)), sub: `Average ${num(avg, 4)}, rounded (.5 rounds up)`, rows: { average: num(avg, 5), stem: hasSci ? String(Math.floor((x.math + x.science) / 2 + 0.5)) : 'Needs a Science score', sections: x.version === 'legacy' ? 'English, Math, Reading, Science' : 'English, Math, Reading (Science reported separately)' }, steps: ['Composite = average of the section scale scores, rounded to the nearest whole number', 'Enhanced ACT (online from April 2025, paper from September 2025): Science and Writing are optional and do not count', 'Converting raw answers to scale scores depends on each test form, so enter your scale scores (ACT User Handbook)'] };
        },
    },
    classroom: {
        type: 'calc',
        inputs: { length: ['Room length', 'length', 'm', 9], width: ['Room width', 'length', 'm', 7], spacing: ['Distance between students (centre to centre)', 'length', 'ft', 6], front: ['Space kept at the front (teacher)', 'length', 'm', 2], margin: ['Gap to the walls', 'length', 'm', 0.5] },
        label: 'Students who fit',
        rows: { grid: 'Seating grid', area: 'Area per student' },
        plots: [['plan', 'Seating plan (dots = students)']],
        run: (x) => {
            const usableL = x.length - x.front - x.margin;
            const usableW = x.width - 2 * x.margin;

            if (!(usableL >= 0 && usableW >= 0 && x.spacing > 0)) {
                return { error: 'The room is too small for these margins.' };
            }

            const rows = Math.floor(usableL / x.spacing + 1e-9) + 1;
            const cols = Math.floor(usableW / x.spacing + 1e-9) + 1;
            const dots = [];

            for (let r = 0; r < rows; r += 1) {
                for (let c = 0; c < cols; c += 1) {
                    dots.push([x.margin + c * x.spacing, x.front + r * x.spacing]);
                }
            }

            return { value: num(rows * cols), sub: `${rows} rows × ${cols} seats`, rows: { grid: `${rows} × ${cols}`, area: `${num((x.length * x.width) / (rows * cols), 4)} m² per student` }, steps: ['Seats sit on a square grid with the chosen spacing between centres, inside the usable area', 'Staggered rows can fit a few more; this is a planning estimate'], plots: { plan: { kind: 'diagram', shapes: [{ points: [[0, 0], [x.width, 0], [x.width, x.length], [0, x.length], [0, 0]], muted: true }, { points: [[0, x.front], [x.width, x.front]], dashed: true, muted: true }], dots: dots.map(([a, b]) => [a, x.length - b]) } } };
        },
    },
    college_gpa: {
        type: 'calc',
        inputs: { courses: TXT('This term: course, grade, credits (one per line)', 'Calculus, A-, 4\nChemistry, B+, 4\nEnglish, A, 3\nHistory, B, 3'), prevGpa: N('Cumulative GPA so far (optional)', 3.2, 0), prevCredits: N('Credits so far (optional)', 45, 0), target: N('Target cumulative GPA (optional)', 3.5, 0), nextCredits: N('Credits next term (for the target)', 15, 0) },
        optional: ['prevGpa', 'prevCredits', 'target', 'nextCredits'],
        label: 'Term GPA',
        rows: { cumulative: 'Cumulative GPA', credits: 'Credits this term', needed: 'GPA needed next term for the target' },
        grids: [['table', 'Courses']],
        run: (x) => {
            const r = readCourses(x.courses);

            if (!r.courses) {
                return r.problem ? { error: r.problem } : r;
            }

            const pts = r.courses.map((c) => points(c.grade));

            if (pts.some((p) => !Number.isFinite(p))) {
                return { error: 'Use letter grades (A, B+ …), percentages (87%) or grade points (3.3).' };
            }

            const cr = sum(r.courses.map((c) => c.credits));
            const qp = sum(r.courses.map((c, i) => c.credits * pts[i]));
            const gpa = qp / cr;
            const hasPrev = x.prevGpa >= 0 && x.prevCredits > 0;
            const cumCr = cr + (hasPrev ? x.prevCredits : 0);
            const cum = (qp + (hasPrev ? x.prevGpa * x.prevCredits : 0)) / cumCr;
            let needed = 'Enter a target and next term’s credits';

            if (x.target > 0 && x.nextCredits > 0) {
                const n = (x.target * (cumCr + x.nextCredits) - cum * cumCr) / x.nextCredits;
                needed = n > 4 ? `${num(n, 3)} (above 4.0: not reachable in one term)` : n <= 0 ? 'Already above the target' : num(n, 3);
            }

            return { value: num(gpa, 3), sub: `${num(cr)} credits`, rows: { cumulative: hasPrev ? num(cum, 3) : num(gpa, 3), credits: num(cr), needed }, steps: ['GPA = Σ(grade points × credits) ÷ Σ credits', 'A = 4.0, A− = 3.7, B+ = 3.3 … F = 0 (the common US 4.0 scale; check your college’s)', 'Cumulative GPA weights each term by its credits'], grids: { table: { columns: ['Grade', 'Points', 'Credits', 'Quality points'], rows: r.courses.map((c, i) => ({ header: c.name, cells: [c.grade, num(pts[i], 3), num(c.credits), num(pts[i] * c.credits, 4)] })) } } };
        },
    },
    final_grade: {
        type: 'calc',
        inputs: { current: N('Current grade (%)', 84, 0), weight: N('Final exam weight (%)', 30, 0), target: N('Grade you want (%)', 85, 0) },
        label: 'Score needed on the final',
        rows: { letter: 'Target letter grade', table: 'Course grade for each final score' },
        run: (x) => {
            const w = x.weight / 100;

            if (!(w > 0 && w <= 1)) {
                return { error: 'The final’s weight must be between 0 and 100%.' };
            }

            const need = (x.target - x.current * (1 - w)) / w;
            const course = (f) => x.current * (1 - w) + f * w;

            return { value: `${num(need, 4)}%`, sub: need > 100 ? 'More than 100%: the target is out of reach' : need <= 0 ? 'Already secured' : `on a final worth ${num(x.weight)}%`, rows: { letter: letterFor(x.target), table: [100, 90, 80, 70, 60].map((f) => `${f}% → ${num(course(f), 4)}%`).join('; ') }, steps: ['Needed = (target − current × (1 − w)) ÷ w', `= (${num(x.target)} − ${num(x.current)} × ${num(1 - w)}) ÷ ${num(w)} = ${num(need, 6)}%`] };
        },
    },
    gpa: {
        type: 'calc',
        inputs: { courses: TXT('Courses: name, grade, credits (one per line)', 'Biology, A, 4\nAlgebra, B+, 3\nSpanish, A-, 3\nArt, B, 2'), scale: SEL('Scale', { 4: '4.0 (A and A+ = 4.0)', 4.3: '4.3 (A+ = 4.3)' }, '4') },
        label: 'GPA',
        rows: { credits: 'Total credits', quality: 'Quality points', letter: 'Average letter' },
        run: (x) => {
            const r = readCourses(x.courses);

            if (!r.courses) {
                return r.problem ? { error: r.problem } : r;
            }

            const pts = r.courses.map((c) => points(c.grade, Number(x.scale)));

            if (pts.some((p) => !Number.isFinite(p))) {
                return { error: 'Use letter grades, percentages or grade points.' };
            }

            const cr = sum(r.courses.map((c) => c.credits));
            const gpa = sum(r.courses.map((c, i) => c.credits * pts[i])) / cr;
            const letter = Object.entries(LETTER_POINTS).find(([, p]) => gpa >= p - 0.15)?.[0] ?? 'F';

            return { value: num(gpa, 3), sub: `on a ${x.scale} scale`, rows: { credits: num(cr), quality: num(gpa * cr, 4), letter }, steps: ['GPA = Σ(points × credits) ÷ Σ credits', 'Letters: A 4.0, A− 3.7, B+ 3.3, B 3.0, B− 2.7, C+ 2.3, C 2.0, C− 1.7, D+ 1.3, D 1.0, F 0'] };
        },
    },
    gpa_pakistan: {
        type: 'calc',
        inputs: { courses: TXT('Courses: name, marks % (or letter), credit hours', 'Calculus, 88, 3\nPhysics, 76, 4\nEnglish, 69, 2\nProgramming, 82, 3') },
        data: ['hec'],
        label: 'GPA',
        rows: { credits: 'Credit hours', percent: 'Equivalent percentage (band minimum)', letter: 'Letter for the GPA' },
        grids: [['table', 'Courses']],
        run: (x, ctx) => {
            const hec = ctx.c.data.other?.hec ?? [];
            const r = readCourses(x.courses);

            if (!r.courses) {
                return r.problem ? { error: r.problem } : r;
            }

            const rows = r.courses.map((c) => {
                const v = Number(String(c.grade).replace('%', ''));
                const band = Number.isFinite(v) ? hec.find((b) => v >= b.min) : hec.find((b) => b.grade === String(c.grade).toUpperCase());

                return { ...c, band };
            });

            if (rows.some((c) => !c.band)) {
                return { error: 'Enter marks as percentages (0–100) or HEC letters (A, A-, B+ …).' };
            }

            const cr = sum(rows.map((c) => c.credits));
            const gpa = sum(rows.map((c) => c.credits * c.band.gp)) / cr;
            const bandOf = [...hec].reverse().find((b) => gpa >= b.lo - 1e-9 && gpa <= b.hi + 1e-9) ?? hec.find((b) => gpa >= b.lo);

            return { value: num(gpa, 3), sub: `${num(cr)} credit hours`, rows: { credits: num(cr), percent: bandOf ? `${bandOf.min}%` : '—', letter: bandOf?.grade ?? '—' }, steps: ['HEC uniform grading: 85%+ A, 80–84 A−, 75–79 B+, 71–74 B, 68–70 B−, 64–67 C+, 61–63 C, 58–60 C−, 54–57 D+, 50–53 D, below 50 F', 'Each course’s letter carries HEC’s point value (A 4.00, A− 3.66, B+ 3.33 …); GPA is the credit-weighted mean', 'A GPA converts to the minimum % of its band (HEC 2019 guidelines); some universities use their own scale'], grids: { table: { columns: ['Marks', 'Grade', 'Points', 'Credits'], rows: rows.map((c) => ({ header: c.name, cells: [c.grade, c.band.grade, num(c.band.gp, 3), num(c.credits)] })) } } };
        },
    },
    grade: {
        type: 'calc',
        inputs: { items: TXT('Assignments: name, score %, weight % (leave score blank if not done yet)', 'Homework, 92, 20\nQuizzes, 85, 20\nMidterm, 78, 25\nFinal exam, , 35'), target: N('Target course grade (%)', 85, 0) },
        optional: ['target'],
        label: 'Current grade',
        rows: { letter: 'Letter grade', weightDone: 'Weight completed', needed: 'Average needed on the rest' },
        run: (x) => {
            const lines = String(x.items ?? '').split(/\r?\n/).map((l) => l.trim()).filter(Boolean);
            const items = lines.map((l) => {
                const p = l.split(/\s*[,;\t]\s*/);

                return { name: p.length > 2 ? p.slice(0, -2).join(', ') : p[0], score: p.length > 2 && p[p.length - 2] !== '' ? Number(p[p.length - 2]) : NaN, weight: Number(p[p.length - 1]) };
            });

            if (!items.length || items.some((i) => !(i.weight >= 0))) {
                return { error: 'Each line needs a name, a score (or blank) and a weight.' };
            }

            const done = items.filter((i) => Number.isFinite(i.score));
            const wDone = sum(done.map((i) => i.weight));
            const wAll = sum(items.map((i) => i.weight));

            if (!(wDone > 0)) {
                return { empty: 'Enter at least one score.' };
            }

            const current = sum(done.map((i) => i.score * i.weight)) / wDone;
            const remaining = wAll - wDone;
            const needed = x.target > 0 && remaining > 0 ? (x.target * wAll - current * wDone) / remaining : NaN;

            return { value: `${num(current, 4)}%`, sub: `from ${num(wDone)}% of the course`, rows: { letter: letterFor(current), weightDone: `${num(wDone)}% of ${num(wAll)}%`, needed: Number.isFinite(needed) ? (needed > 100 ? `${num(needed, 4)}% (out of reach)` : `${num(needed, 4)}%`) : remaining > 0 ? 'Enter a target' : 'Nothing left to grade' }, steps: ['Current grade = Σ(score × weight) ÷ Σ(weights of graded work)', 'Needed = (target × total weight − current × graded weight) ÷ remaining weight', 'Letter grades: 93% A, 90% A−, 87% B+ … (a common US scale)'] };
        },
    },
    grade_curve: {
        type: 'calc',
        inputs: { scores: TXT('Scores (%)', '45, 52, 58, 61, 64, 67, 70, 72, 75, 79, 83, 88'), method: SEL('Curve', { flat: 'Flat: add the same points to everyone', top: 'Highest score becomes 100', sqrt: 'Square root (10 × √score)', bell: 'Bell curve to a target mean and SD' }, 'flat'), add: N('Points to add (flat)', 7, 0), mean: N('Target mean (bell)', 75, 0), sdTarget: N('Target SD (bell)', 10, 0), cap: SEL('Cap at 100?', { yes: 'Yes', no: 'No' }, 'yes') },
        show: { add: 'method:flat', mean: 'method:bell', sdTarget: 'method:bell' },
        when: { add: (x) => x.method === 'flat', mean: (x) => x.method === 'bell', sdTarget: (x) => x.method === 'bell' },
        label: 'New average',
        rows: { before: 'Average before', range: 'New lowest and highest' },
        grids: [['table', 'Each score']],
        run: (x) => {
            const { values } = parseNumbers(x.scores);

            if (values.length < 2) {
                return { empty: 'Enter at least two scores.' };
            }

            const m = mean(values);
            const s = sd(values);
            const top = Math.max(...values);
            const f = { flat: (v) => v + x.add, top: (v) => (v * 100) / top, sqrt: (v) => 10 * Math.sqrt(Math.max(0, v)), bell: (v) => x.mean + ((v - m) / s) * x.sdTarget }[x.method];
            const curved = values.map((v) => (x.cap === 'yes' ? Math.min(100, f(v)) : f(v)));

            return { value: `${num(mean(curved), 4)}%`, sub: `${values.length} scores`, rows: { before: `${num(m, 4)}%`, range: `${num(Math.min(...curved), 4)}% and ${num(Math.max(...curved), 4)}%` }, steps: [{ flat: 'Flat: everyone gets the same extra points', top: 'Scale: multiply by 100 ÷ the highest score', sqrt: 'Root curve: 10 × √score lifts low scores most', bell: 'Bell curve: new = target mean + z × target SD, with z = (score − mean) ÷ SD' }[x.method]], grids: { table: { columns: ['Curved', 'Letter'], rows: values.map((v, i) => ({ header: `${num(v)}%`, cells: [`${num(curved[i], 4)}%`, letterFor(curved[i])] })) } } };
        },
    },
    graduation: {
        type: 'calc',
        inputs: { birth: ['Date of birth', 'date', null, '2010-03-15'], system: SEL('School system', { us: 'United States (K at 5 by 1 Sept; 13 years K–12)', england: 'England & Wales (Reception at 4 by 1 Sept; to Year 13)', custom: 'Custom' }, 'us'), cutoffMonth: N('Cut-off month (1–12)', 9, 1), cutoffDay: N('Cut-off day', 1, 1), startAge: N('Age to start by the cut-off', 5, 0), years: N('Years of school to graduation', 13, 1), year: N('What grade in school year starting (optional)', 2026, 1900) },
        show: { cutoffMonth: 'system:custom', cutoffDay: 'system:custom', startAge: 'system:custom', years: 'system:custom' },
        optional: ['year'],
        label: 'Expected graduation year',
        rows: { start: 'First school year', grade: 'Grade in the chosen year', age: 'Age at graduation' },
        run: (x) => {
            const m = String(x.birth ?? '').match(/^(\d{4})-(\d{2})-(\d{2})$/);

            if (!m) {
                return { error: 'Enter a date of birth.' };
            }

            const [by, bm, bd] = m.slice(1).map(Number);
            const rule = { us: [9, 1, 5, 13, ['K', '1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th']], england: [9, 1, 4, 14, ['Reception', 'Year 1', 'Year 2', 'Year 3', 'Year 4', 'Year 5', 'Year 6', 'Year 7', 'Year 8', 'Year 9', 'Year 10', 'Year 11', 'Year 12', 'Year 13']] }[x.system] ?? [x.cutoffMonth, x.cutoffDay, x.startAge, x.years, null];
            const [cm, cd, age, years, names] = rule;
            const turnsByCutoff = bm < cm || (bm === cm && bd <= cd);
            const startYear = by + age + (turnsByCutoff ? 0 : 1);
            const gradYear = startYear + years;
            let grade = 'Enter a school year';

            if (Number.isInteger(x.year)) {
                const k = x.year - startYear;
                grade = k < 0 ? 'Not yet at school' : k >= years ? 'Graduated' : names ? names[k] : `Year ${k + 1} of school`;
            }

            return { value: String(gradYear), sub: `school year ${gradYear - 1}–${String(gradYear).slice(2)}`, rows: { start: `${startYear}–${String(startYear + 1).slice(2)}`, grade, age: `about ${gradYear - by - (bm > 6 ? 1 : 0)}` }, steps: [`Children who reach age ${age} by ${cd}/${cm} start that September`, 'Graduation is at the end of the last school year', 'US cut-off dates vary by state (1 September is the most common)'] };
        },
    },
    gwa: {
        type: 'calc',
        inputs: { subjects: TXT('Subjects: name, grade (1.00–5.00), units', 'Math 21, 1.75, 3\nChem 16, 2.00, 4\nEng 10, 1.25, 3\nPE 2, 1.50, 2') },
        label: 'General weighted average',
        rows: { units: 'Total units', best: 'Best grade' },
        run: (x) => {
            const r = readCourses(x.subjects);

            if (!r.courses) {
                return r.problem ? { error: r.problem } : r;
            }

            const g = r.courses.map((c) => Number(c.grade));

            if (g.some((v) => !(v >= 1 && v <= 5))) {
                return { error: 'Grades are on the 1.00 (highest) to 5.00 scale.' };
            }

            const u = sum(r.courses.map((c) => c.credits));
            const gwa = sum(r.courses.map((c, i) => g[i] * c.credits)) / u;

            return { value: num(gwa, 4), sub: `${num(u)} units`, rows: { units: num(u), best: num(Math.min(...g), 3) }, steps: ['GWA = Σ(grade × units) ÷ Σ units', 'On the Philippine 1.00–5.00 scale, lower is better; 3.00 is usually the passing grade', 'Latin-honours cut-offs differ between universities'] };
        },
    },
    hs_gpa: {
        type: 'calc',
        inputs: { courses: TXT('Classes: name, grade, credits, level (R, H or AP/IB)', 'English 11, A-, 1, H\nAP Chemistry, B+, 1, AP\nAlgebra II, A, 1, R\nUS History, B, 1, AP\nSpanish III, A, 1, R') },
        label: 'Weighted GPA',
        rows: { unweighted: 'Unweighted GPA', credits: 'Credits' },
        run: (x) => {
            const r = readCourses(x.courses, { level: true });

            if (!r.courses) {
                return r.problem ? { error: r.problem } : r;
            }

            const pts = r.courses.map((c) => points(c.grade));

            if (pts.some((p) => !Number.isFinite(p))) {
                return { error: 'Use letter grades, percentages or points.' };
            }

            const bonus = (c, p) => (p > 0 ? ({ h: 0.5, honors: 0.5, honours: 0.5, ap: 1, ib: 1 }[c.level] ?? 0) : 0);
            const cr = sum(r.courses.map((c) => c.credits));
            const unw = sum(r.courses.map((c, i) => c.credits * pts[i])) / cr;
            const w = sum(r.courses.map((c, i) => c.credits * (pts[i] + bonus(c, pts[i])))) / cr;

            return { value: num(w, 3), sub: 'Honors +0.5, AP/IB +1.0', rows: { unweighted: num(unw, 3), credits: num(cr) }, steps: ['Unweighted: A = 4.0 … F = 0', 'Weighted: add 0.5 for honors and 1.0 for AP or IB classes (no bonus for an F) — a common scheme; schools differ'] };
        },
    },
    ielts: {
        type: 'calc',
        inputs: { listening: N('Listening band (or raw, see below)', 7, 0), reading: N('Reading band', 6.5, 0), writing: N('Writing band', 6, 0), speaking: N('Speaking band', 7, 0), raw: SEL('Listening and Reading entered as', { band: 'Band scores', raw: 'Raw scores out of 40' }, 'band'), test: SEL('Test (for raw Reading)', { academic: 'Academic', general: 'General Training' }, 'academic') },
        show: { test: 'raw:raw' },
        data: ['ielts'],
        label: 'Overall band',
        rows: { average: 'Exact average', bands: 'Bands used', level: 'Typical description' },
        run: (x, ctx) => {
            const t = ctx.c.data.other?.ielts ?? {};
            let L = x.listening;
            let R = x.reading;

            if (x.raw === 'raw') {
                if (!(L >= 0 && L <= 40 && R >= 0 && R <= 40)) {
                    return { error: 'Raw scores are 0–40.' };
                }

                L = bandFor(t.listening, L);
                R = bandFor(t[x.test], R);

                if (L === null || R === null) {
                    return { error: 'That raw score is below the published conversion table.' };
                }
            }

            const bands = [L, R, x.writing, x.speaking];

            if (!bands.every((b) => b >= 0 && b <= 9 && Math.abs(b * 2 - Math.round(b * 2)) < 1e-9)) {
                return { error: 'Band scores go from 0 to 9 in steps of 0.5.' };
            }

            const o = ieltsOverall(bands);
            const level = { 9: 'Expert', 8.5: 'Very good–expert', 8: 'Very good', 7.5: 'Good–very good', 7: 'Good', 6.5: 'Competent–good', 6: 'Competent', 5.5: 'Modest–competent', 5: 'Modest', 4.5: 'Limited–modest', 4: 'Limited' }[o] ?? 'Extremely limited or below';

            return { value: num(o, 2), sub: `L ${num(L)} · R ${num(R)} · W ${num(x.writing)} · S ${num(x.speaking)}`, rows: { average: num(mean(bands), 4), bands: bands.map((b) => num(b)).join(', '), level }, steps: ['Overall = average of the four skills, rounded to the nearest half band', 'An average ending in .25 rounds up to the next half band, and .75 up to the next whole band (ielts.org)', ...(x.raw === 'raw' ? ['Raw-to-band tables vary slightly between test versions (published averages)'] : [])] };
        },
    },
    impact_factor: {
        type: 'calc',
        inputs: { cites: N('Citations this year to items published in the previous two years', 1520, 0), items: N('Citable items published in those two years', 410, 1), cites5: N('Citations to the previous five years (optional)', 3200, 0), items5: N('Citable items in those five years (optional)', 1050, 0) },
        optional: ['cites5', 'items5'],
        label: 'Impact factor',
        rows: { five: 'Five-year impact factor' },
        run: (x) => ({ value: num(x.cites / x.items, 4), sub: 'two-year journal impact factor', rows: { five: x.cites5 >= 0 && x.items5 > 0 ? num(x.cites5 / x.items5, 4) : 'Enter five-year figures' }, steps: ['JIF(Y) = citations in year Y to items from Y−1 and Y−2 ÷ citable items from Y−1 and Y−2 (Clarivate)', 'Only Clarivate’s Journal Citation Reports publish official values; compare journals within the same field'] }),
    },
    ms_gpa: {
        type: 'calc',
        inputs: { grades: TXT('Grades (one per subject: letters or %)', 'A, B+, A-, B, A, C+') },
        label: 'GPA',
        rows: { subjects: 'Subjects', letter: 'Average letter' },
        run: (x) => {
            const tokens = String(x.grades ?? '').split(/[\s,;]+/).filter(Boolean);
            const pts = tokens.map((t) => points(t));

            if (!tokens.length || pts.some((p) => !Number.isFinite(p))) {
                return { error: 'Enter letter grades (A, B+ …) or percentages.' };
            }

            const g = mean(pts);

            return { value: num(g, 3), sub: '4.0 scale, each subject counts equally', rows: { subjects: num(tokens.length), letter: Object.entries(LETTER_POINTS).find(([, p]) => g >= p - 0.15)?.[0] ?? 'F' }, steps: ['Middle-school GPA is usually the plain average of subject grade points', 'A = 4.0, B = 3.0, C = 2.0, D = 1.0, F = 0 (± add or subtract 0.3)'] };
        },
    },
    pte: {
        type: 'calc',
        inputs: { pte: N('PTE Academic overall score (10–90)', 65, 10) },
        data: ['pte_ielts'],
        label: 'Equivalent IELTS band',
        rows: { range: 'PTE range for that band', next: 'Score for the next band' },
        grids: [['table', 'Pearson concordance (July 2025)']],
        run: (x, ctx) => {
            const t = ctx.c.data.other?.pte_ielts ?? [];

            if (!(x.pte >= 10 && x.pte <= 90)) {
                return { error: 'PTE scores go from 10 to 90.' };
            }

            const i = t.findIndex(([min]) => x.pte >= min);
            const band = i >= 0 ? t[i] : null;

            return { value: band ? num(band[1], 2) : 'Below 4.5', sub: `PTE ${num(x.pte)}`, rows: { range: band ? `${band[0]}${i > 0 ? `–${t[i - 1][0] - 1}` : '–90'}` : `10–${t[t.length - 1][0] - 1}`, next: i > 0 ? `${t[i - 1][0]} for IELTS ${num(t[i - 1][1], 2)}` : i === 0 ? 'Highest band' : `${t[t.length - 1][0]} for IELTS ${num(t[t.length - 1][1], 2)}` }, steps: ['Pearson’s published concordance between PTE Academic and IELTS Academic overall scores (research published July 2025)', 'Universities and visa authorities set their own accepted equivalents; check the one that applies to you', 'The PTE overall score is not an average of the sub-scores, so it cannot be computed from them'], grids: { table: { columns: ['Minimum PTE'], rows: t.map(([min, b]) => ({ header: `IELTS ${num(b, 2)}`, cells: [String(min)], highlight: band && b === band[1] })) } } };
        },
    },
    semester: {
        type: 'calc',
        inputs: { q1: N('Term 1 (quarter) grade (%)', 88, 0), q2: N('Term 2 grade (%)', 82, 0), w1: N('Term 1 weight (%)', 40, 0), w2: N('Term 2 weight (%)', 40, 0), exam: N('Final exam (%, blank if not taken)', 90, 0), we: N('Final exam weight (%)', 20, 0), target: N('Target semester grade (optional)', 90, 0) },
        optional: ['exam', 'target'],
        label: 'Semester grade',
        rows: { letter: 'Letter', needed: 'Exam score needed for the target' },
        run: (x) => {
            const total = x.w1 + x.w2 + x.we;

            if (Math.abs(total - 100) > 1e-6) {
                return { error: `The weights add up to ${num(total)}%; they must add up to 100%.` };
            }

            const terms = (x.q1 * x.w1 + x.q2 * x.w2) / 100;
            const grade = Number.isFinite(x.exam) ? terms + (x.exam * x.we) / 100 : (terms * 100) / (x.w1 + x.w2);
            const needed = x.target > 0 && x.we > 0 ? ((x.target - terms) * 100) / x.we : NaN;

            return { value: `${num(grade, 4)}%`, sub: Number.isFinite(x.exam) ? 'with the final exam' : 'before the exam (terms only)', rows: { letter: letterFor(grade), needed: Number.isFinite(needed) ? (needed > 100 ? `${num(needed, 4)}% (out of reach)` : `${num(needed, 4)}%`) : 'Enter a target' }, steps: ['Semester = Σ(term grade × weight) + exam × exam weight', 'Needed exam = (target − weighted terms) ÷ exam weight'] };
        },
    },
    test_grade: {
        type: 'calc',
        inputs: { total: N('Questions (or points) in the test', 40, 1), wrong: N('Wrong answers (or points lost)', 7, 0) },
        label: 'Score',
        rows: { letter: 'Letter grade', right: 'Correct' },
        grids: [['table', 'Grading table']],
        run: (x) => {
            if (!(x.wrong >= 0 && x.wrong <= x.total)) {
                return { error: 'Wrong answers must be between 0 and the total.' };
            }

            const p = ((x.total - x.wrong) / x.total) * 100;

            return { value: `${num(p, 4)}%`, sub: `${num(x.total - x.wrong)} of ${num(x.total)}`, rows: { letter: letterFor(p), right: num(x.total - x.wrong) }, steps: ['Score = correct ÷ total × 100', 'Letters on the common US scale (93% A, 90% A− …)'], grids: { table: { columns: ['Score', 'Letter'], rows: Array.from({ length: Math.min(x.total, 60) + 1 }, (_, w) => ({ header: `${w} wrong`, cells: [`${num(((x.total - w) / x.total) * 100, 4)}%`, letterFor(((x.total - w) / x.total) * 100)], highlight: w === x.wrong })) } } };
        },
    },
    cgpa_percent: {
        type: 'calc',
        inputs: { cgpa: N('CGPA (or CGPI)', 8.4, 0), board: SEL('Board or university', { cbse: 'CBSE (× 9.5)', vtu15: 'VTU, 2015–2018 schemes ((CGPA − 0.75) × 10)', vtu22: 'VTU, 2022 scheme onward (× 10)', anna: 'Anna University, R2021 (× 10)', mumbai: 'University of Mumbai, CBCS (7.25 × CGPI + 11)', hec: 'HEC Pakistan (4.0 scale: band minimum)', custom: 'My own multiplier' }, 'cbse'), mult: N('Multiplier (custom)', 9.5, 0) },
        show: { mult: 'board:custom' },
        when: { mult: (x) => x.board === 'custom' },
        data: ['hec'],
        label: 'Percentage',
        rows: { formula: 'Formula', klass: 'Class / division (where defined)' },
        run: (x, ctx) => {
            const c = x.cgpa;
            let p;
            let formula;

            if (x.board === 'hec') {
                if (!(c >= 0 && c <= 4)) {
                    return { error: 'HEC CGPA is on a 4.0 scale.' };
                }

                const hec = ctx.c.data.other?.hec ?? [];
                const band = hec.find((b) => c >= b.lo - 1e-9) ?? hec[hec.length - 1];
                p = band.min;
                formula = `CGPA ${num(c)} falls in the ${band.grade} band (${band.lo}–${band.hi}); its minimum is ${band.min}% (HEC 2019 guidelines)`;
            } else {
                if (!(c >= 0 && c <= 10)) {
                    return { error: 'CGPA is on a 10-point scale.' };
                }

                const rules = { cbse: [9.5 * c, '% = CGPA × 9.5 (CBSE Circular 24/2010)'], vtu15: [(c - 0.75) * 10, '% = (CGPA − 0.75) × 10 (VTU, 2015–2018 schemes)'], vtu22: [c * 10, '% = CGPA × 10 (VTU 2022 regulations)'], anna: [c * 10, '% = CGPA × 10 (Anna University R2021, cl. 15.5.3)'], mumbai: [Math.ceil(7.25 * c + 11 - 1e-9), '% = 7.25 × CGPI + 11, rounded up (University of Mumbai circular, 17 Oct 2018)'], custom: [c * x.mult, `% = CGPA × ${num(x.mult)}`] }[x.board];
                [p, formula] = rules;
            }

            const klass = x.board.startsWith('vtu') && x.board === 'vtu15' ? (p >= 70 ? 'First class with distinction' : p >= 60 ? 'First class' : 'Second class') : 'Not defined for this board';

            return { value: `${num(p, 4)}%`, sub: `CGPA ${num(c)}`, rows: { formula, klass }, steps: [formula, 'Use the formula of the board or university that awarded the CGPA; employers may ask for its official conversion certificate'] };
        },
    },
    sgpa_cgpa: {
        type: 'calc',
        inputs: { sems: TXT('Semesters: SGPA, credits (one per line)', '8.2, 22\n7.9, 24\n8.6, 23\n8.8, 21') },
        label: 'CGPA',
        rows: { credits: 'Total credits', simple: 'Simple average of SGPAs', cbse: 'Percentage at × 9.5 (CBSE rule)' },
        run: (x) => {
            const rows = String(x.sems ?? '').split(/\r?\n/).map((l) => parseNumbers(l).values).filter((r) => r.length);

            if (!rows.length || rows.some((r) => r.length !== 2 || r[0] < 0 || r[0] > 10 || r[1] <= 0)) {
                return { error: 'Each line needs an SGPA (0–10) and the credits.' };
            }

            const cr = sum(rows.map((r) => r[1]));
            const cgpa = sum(rows.map(([g, c]) => g * c)) / cr;

            return { value: num(cgpa, 4), sub: `${rows.length} semesters`, rows: { credits: num(cr), simple: num(mean(rows.map((r) => r[0])), 4), cbse: `${num(cgpa * 9.5, 4)}%` }, steps: ['CGPA = Σ(SGPA × credits) ÷ Σ credits', 'The simple average is only correct when every semester has the same credits'] };
        },
    },
    attendance: {
        type: 'calc',
        inputs: { held: N('Classes held', 80, 1), attended: N('Classes attended', 56, 0), required: N('Required attendance (%)', 75, 0) },
        label: 'Attendance',
        rows: { need: 'Classes to attend in a row to reach the requirement', bunk: 'Classes you can miss and stay above it' },
        run: (x) => {
            if (!(x.attended >= 0 && x.attended <= x.held) || !(x.required > 0 && x.required < 100)) {
                return { error: 'Attended must be between 0 and the classes held; the requirement between 0 and 100%.' };
            }

            const r = x.required / 100;
            const p = x.attended / x.held;
            const need = p >= r ? 0 : Math.ceil((r * x.held - x.attended) / (1 - r) - 1e-9);
            const bunk = p >= r ? Math.floor(x.attended / r - x.held + 1e-9) : 0;

            return { value: pct(p, 4), sub: `${num(x.attended)} of ${num(x.held)} classes`, rows: { need: need ? num(need) : 'None: already at the requirement', bunk: p >= r ? num(bunk) : 'None until you reach the requirement' }, steps: ['Attendance = attended ÷ held', 'To reach r: (attended + n) ÷ (held + n) ≥ r → n = ⌈(r × held − attended) ÷ (1 − r)⌉', 'Can miss m: attended ÷ (held + m) ≥ r → m = ⌊attended ÷ r − held⌋'] };
        },
    },
};

export const handlers = handlersFor(TOOLS);
export default defineTools(handlers);
