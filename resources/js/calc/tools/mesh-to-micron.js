/**
 * ASTM E11 standard test sieves: US sieve number → nominal opening in micrometers.
 */
export const ASTM_E11 = [
    [3.5, 5600], [4, 4750], [5, 4000], [6, 3350], [7, 2800], [8, 2360], [10, 2000], [12, 1700],
    [14, 1400], [16, 1180], [18, 1000], [20, 850], [25, 710], [30, 600], [35, 500], [40, 425],
    [45, 355], [50, 300], [60, 250], [70, 212], [80, 180], [100, 150], [120, 125], [140, 106],
    [170, 90], [200, 75], [230, 63], [270, 53], [325, 45], [400, 38], [450, 32], [500, 25], [635, 20],
];

// Rule of thumb for non-standard mesh counts: opening (µm) ≈ 14,900 ÷ mesh.
export const ESTIMATE_CONSTANT = 14900;
const NEARBY_COUNT = 12;

export function micronsForMesh(mesh) {
    const standard = ASTM_E11.find(([number]) => number === mesh);

    return standard ? { microns: standard[1], standard: true } : { microns: ESTIMATE_CONSTANT / mesh, standard: false };
}

/**
 * The standard sieve whose opening is closest to the given size.
 */
export function nearestSieve(microns) {
    return ASTM_E11.reduce((best, sieve) => (Math.abs(sieve[1] - microns) < Math.abs(best[1] - microns) ? sieve : best));
}

/**
 * A window of standard sieves around the given one, for the right-panel table.
 */
export function nearbySieves(mesh) {
    const index = ASTM_E11.findIndex(([number]) => number >= mesh);
    const centre = index === -1 ? ASTM_E11.length - 1 : index;
    const start = Math.min(Math.max(centre - NEARBY_COUNT / 2, 0), ASTM_E11.length - NEARBY_COUNT);

    return ASTM_E11.slice(start, start + NEARBY_COUNT);
}

export default function meshToMicron(ctx) {
    ctx.onUpdate(() => {
        const direction = ctx.choice('direction');
        const value = ctx.number('value');
        ctx.setText('value-suffix', direction === 'mesh' ? 'mesh' : 'µm');

        if (Number.isNaN(value)) {
            ctx.clearResult();

            return;
        }

        if (value <= 0) {
            ctx.showError('Enter a number greater than 0.');

            return;
        }

        let mesh;
        let microns;

        if (direction === 'mesh') {
            mesh = value;
            const lookup = micronsForMesh(mesh);
            microns = lookup.microns;
            ctx.showResult({
                value: ctx.format(microns),
                unit: 'µm',
                label: 'Sieve opening',
                sub: lookup.standard ? `ASTM E11 standard sieve No. ${mesh}` : `Estimate: 14,900 ÷ ${ctx.format(mesh)} (not a standard sieve)`,
            });
        } else {
            microns = value;
            [mesh] = nearestSieve(microns);
            ctx.showResult({
                value: `No. ${mesh}`,
                unit: '',
                label: 'Nearest standard sieve',
                sub: `Opening ${ctx.format(micronsForMesh(mesh).microns)} µm · estimate ${ctx.format(ESTIMATE_CONSTANT / microns)} mesh`,
            });
        }

        ctx.setRow('mm', ctx.format(microns / 1000));
        ctx.setRow('in', ctx.format(microns / 25400));

        ctx.renderRows('sieves', nearbySieves(mesh).map(([number, opening]) => ({
            label: `No. ${number}`,
            value: `${ctx.format(opening)} µm`,
            highlight: number === mesh,
        })));
    });
}
