/**
 * Electron structure: configurations, ions, Slater's rules and diatomic molecular orbitals.
 * Neutral-atom ground states come from the NIST Atomic Spectra Database (config/elements.php).
 */
export const L_LETTERS = 'spdfg';
export const CAPACITY = { s: 2, p: 6, d: 10, f: 14, g: 18 };
const NOBLE = { He: 2, Ne: 10, Ar: 18, Kr: 36, Xe: 54, Rn: 86 };

/**
 * Aufbau (Madelung) filling order: by n + l, then n.
 */
export const AUFBAU = (() => {
    const list = [];

    for (let n = 1; n <= 8; n += 1) {
        for (let l = 0; l < Math.min(n, 4); l += 1) {
            list.push([n, l]);
        }
    }

    return list.sort((a, b) => a[0] + a[1] - (b[0] + b[1]) || a[0] - b[0]);
})();

/**
 * Expands a stored configuration ("[Ar] 3d5 4s1") into [{ n, l, electrons }] in n, l order.
 */
export function expandConfiguration(text, elements) {
    const match = /^(?:\[(\w+)\]\s*)?(.*)$/.exec(String(text).trim());
    const subshells = match[1] ? expandConfiguration(elements[match[1]].configuration, elements) : [];

    for (const part of match[2].split(/\s+/).filter(Boolean)) {
        const [, n, letter, count] = /^(\d)([spdfg])(\d+)$/.exec(part);
        subshells.push({ n: Number(n), l: L_LETTERS.indexOf(letter), electrons: Number(count) });
    }

    return sortSubshells(subshells);
}

export function sortSubshells(subshells) {
    return subshells.filter((item) => item.electrons > 0).sort((a, b) => a.n - b.n || a.l - b.l);
}

export const label = (item) => `${item.n}${L_LETTERS[item.l]}`;

export function totalElectrons(subshells) {
    return subshells.reduce((sum, item) => sum + item.electrons, 0);
}

/**
 * Configuration of an ion: electrons leave the highest n first (p before s), so Fe²⁺ is [Ar] 3d6;
 * extra electrons for anions fill by the Aufbau order.
 */
export function ionConfiguration(subshells, charge) {
    const result = subshells.map((item) => ({ ...item }));

    if (charge > 0) {
        for (let removed = 0; removed < charge; removed += 1) {
            const target = [...result].filter((item) => item.electrons > 0).sort((a, b) => b.n - a.n || b.l - a.l)[0];

            if (!target) {
                throw new RangeError('The charge is larger than the number of electrons.');
            }

            target.electrons -= 1;
        }
    } else if (charge < 0) {
        let toAdd = -charge;

        for (const [n, l] of AUFBAU) {
            if (toAdd === 0) {
                break;
            }

            let item = result.find((entry) => entry.n === n && entry.l === l);

            if (!item) {
                item = { n, l, electrons: 0 };
                result.push(item);
            }

            const room = CAPACITY[L_LETTERS[l]] - item.electrons;
            const added = Math.min(room, toAdd);
            item.electrons += added;
            toAdd -= added;
        }
    }

    return sortSubshells(result);
}

/**
 * Full notation "1s2 2s2 2p6 …" and noble-gas shorthand "[Ne] 3s2 3p4".
 */
export function notation(subshells, elements) {
    const full = subshells.map((item) => `${label(item)}${item.electrons}`).join(' ');
    const total = totalElectrons(subshells);
    const core = Object.entries(NOBLE).filter(([, z]) => z < total).sort((a, b) => b[1] - a[1]).find(([symbol]) => {
        const coreShells = expandConfiguration(elements[symbol].configuration, elements);

        return coreShells.every((shell) => subshells.some((item) => item.n === shell.n && item.l === shell.l && item.electrons === shell.electrons));
    });

    if (!core) {
        return { full, short: full };
    }

    const coreShells = expandConfiguration(elements[core[0]].configuration, elements);
    const rest = subshells.filter((item) => !coreShells.some((shell) => shell.n === item.n && shell.l === item.l));

    return { full, short: `[${core[0]}] ${rest.map((item) => `${label(item)}${item.electrons}`).join(' ')}`.trim() };
}

/**
 * Unpaired electrons by Hund's rule in each subshell.
 */
export function unpairedElectrons(subshells) {
    return subshells.reduce((sum, item) => {
        const orbitals = CAPACITY[L_LETTERS[item.l]] / 2;

        return sum + (item.electrons <= orbitals ? item.electrons : 2 * orbitals - item.electrons);
    }, 0);
}

/**
 * Orbital boxes for one subshell, e.g. 2p4 → "↑↓ ↑ ↑".
 */
export function orbitalBoxes(item) {
    const orbitals = CAPACITY[L_LETTERS[item.l]] / 2;

    return Array.from({ length: orbitals }, (_, index) => {
        const up = index < Math.min(item.electrons, orbitals);
        const down = index < item.electrons - orbitals;

        return `[${up ? '↑' : ' '}${down ? '↓' : ' '}]`;
    }).join('');
}

/**
 * Valence electrons: the outermost shell, plus an unfilled (n−1)d for transition metals.
 */
export function valenceElectrons(subshells) {
    const outer = Math.max(...subshells.map((item) => item.n));
    const outerShell = subshells.filter((item) => item.n === outer).reduce((sum, item) => sum + item.electrons, 0);
    const d = subshells.find((item) => item.n === outer - 1 && item.l === 2);

    return d && d.electrons < 10 ? outerShell + d.electrons : outerShell;
}

/**
 * Slater's rules (1930) for one electron in subshell n, l.
 * Groups, in order: (1s)(2s,2p)(3s,3p)(3d)(4s,4p)(4d)(4f)(5s,5p)(5d)(5f)(6s,6p)(6d)(7s,7p).
 *   Same group: 0.35 each (0.30 within 1s). Groups to the right: 0.
 *   s or p electron: 0.85 for each electron with principal number n − 1, 1.00 for n − 2 and lower.
 *   d or f electron: 1.00 for every electron in a group to the left.
 */
export function slater(subshells, z, n, l) {
    const target = subshells.find((item) => item.n === n && item.l === l);

    if (!target || target.electrons === 0) {
        throw new RangeError('That orbital holds no electrons in this atom.');
    }

    const groupOrder = (item) => item.n * 10 + (item.l <= 1 ? 0 : item.l - 1);
    const targetGroup = groupOrder(target);
    const breakdown = [];
    let shielding = 0;

    for (const item of subshells) {
        const group = groupOrder(item);
        let electrons = item.electrons;
        let each = 0;

        if (group === targetGroup) {
            electrons -= item === target ? 1 : 0;
            each = n === 1 ? 0.3 : 0.35;
        } else if (group < targetGroup) {
            each = target.l >= 2 || item.n <= n - 2 ? 1 : 0.85;
        }

        if (each > 0 && electrons > 0) {
            shielding += electrons * each;
            breakdown.push({ group: label(item), electrons, each });
        }
    }

    return { shielding, zeff: z - shielding, breakdown };
}

/**
 * Molecular orbital filling for diatomics of period 1 or period 2 atoms.
 * Up to 14 electrons (N₂) the σ2p lies above π2p (s–p mixing); from O₂ on it lies below.
 */
export function diatomicOrbitals(totalElectrons, period) {
    if (period === 1) {
        return fill(['σ1s', 'σ*1s'], totalElectrons);
    }

    const mixed = totalElectrons <= 14;
    const order = mixed
        ? ['σ1s', 'σ*1s', 'σ2s', 'σ*2s', 'π2p', 'σ2p', 'π*2p', 'σ*2p']
        : ['σ1s', 'σ*1s', 'σ2s', 'σ*2s', 'σ2p', 'π2p', 'π*2p', 'σ*2p'];

    return fill(order, totalElectrons);
}

function fill(order, electrons) {
    let left = electrons;

    return order.map((name) => {
        const capacity = name.startsWith('π') ? 4 : 2;
        const count = Math.min(capacity, left);
        left -= count;

        return { name, electrons: count, capacity, antibonding: name.includes('*') };
    }).concat(left > 0 ? [{ name: 'overflow', electrons: left, capacity: 0, antibonding: false }] : []);
}

export function bondOrderFromOrbitals(orbitals) {
    const bonding = orbitals.filter((item) => !item.antibonding).reduce((sum, item) => sum + item.electrons, 0);
    const antibonding = orbitals.filter((item) => item.antibonding).reduce((sum, item) => sum + item.electrons, 0);
    const unpaired = orbitals.reduce((sum, item) => {
        const orbitalsInLevel = item.capacity / 2;

        return sum + (item.electrons <= orbitalsInLevel ? item.electrons : item.capacity - item.electrons);
    }, 0);

    return { bonding, antibonding, order: (bonding - antibonding) / 2, unpaired };
}
