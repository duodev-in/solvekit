/**
 * Laboratory units: each analyte lists its units as factors to the conventional US unit (value in unit × factor = conventional).
 * Molar factors use the analyte's molar mass (glucose 180.16, cholesterol 386.65, triglycerides 885.7 as triolein, creatinine 113.12,
 * urea nitrogen 28.01 per mmol of urea, calcium 40.08, magnesium 24.31 as mEq/L ↔ mg/dL, bilirubin 584.66, uric acid 168.11).
 */
export const ANALYTES = {
    glucose: { name: 'Glucose', base: 'mg/dL', units: { 'mg/dL': 1, 'mmol/L': 18.016 } },
    cholesterol: { name: 'Cholesterol', base: 'mg/dL', units: { 'mg/dL': 1, 'mmol/L': 38.67 } },
    triglycerides: { name: 'Triglycerides', base: 'mg/dL', units: { 'mg/dL': 1, 'mmol/L': 88.57 } },
    creatinine: { name: 'Creatinine', base: 'mg/dL', units: { 'mg/dL': 1, 'µmol/L': 1 / 88.42 } },
    ucreat: { name: 'Urine creatinine', base: 'mg/dL', units: { 'mg/dL': 1, 'mmol/L': 11.312, 'µmol/L': 1 / 88.42 } },
    bun: { name: 'Urea nitrogen (BUN)', base: 'mg/dL', units: { 'mg/dL BUN': 1, 'mmol/L urea': 2.801 } },
    calcium: { name: 'Calcium', base: 'mg/dL', units: { 'mg/dL': 1, 'mmol/L': 4.008 } },
    magnesium: { name: 'Magnesium', base: 'mg/dL', units: { 'mg/dL': 1, 'mmol/L': 2.431, 'mEq/L': 1.2155 } },
    albumin: { name: 'Albumin', base: 'g/dL', units: { 'g/dL': 1, 'g/L': 0.1 } },
    protein: { name: 'Total protein', base: 'g/dL', units: { 'g/dL': 1, 'g/L': 0.1 } },
    bilirubin: { name: 'Bilirubin', base: 'mg/dL', units: { 'mg/dL': 1, 'µmol/L': 1 / 17.104 } },
    hemoglobin: { name: 'Hemoglobin', base: 'g/dL', units: { 'g/dL': 1, 'g/L': 0.1, 'mmol/L': 1.611 } },
    uric: { name: 'Uric acid', base: 'mg/dL', units: { 'mg/dL': 1, 'µmol/L': 1 / 59.48 } },
    insulin: { name: 'Insulin', base: 'µU/mL', units: { 'µU/mL': 1, 'pmol/L': 1 / 6 } },
    testosterone: { name: 'Testosterone', base: 'ng/dL', units: { 'ng/dL': 1, 'nmol/L': 28.84 } },
    estradiol: { name: 'Estradiol', base: 'pg/mL', units: { 'pg/mL': 1, 'pmol/L': 1 / 3.671 } },
    progesterone: { name: 'Progesterone', base: 'ng/mL', units: { 'ng/mL': 1, 'nmol/L': 1 / 3.18 } },
    iron: { name: 'Iron', base: 'µg/dL', units: { 'µg/dL': 1, 'µmol/L': 5.585 } },
    platelets: { name: 'Platelets', base: '×10⁹/L', units: { '×10⁹/L': 1, '×10³/µL': 1 } },
    ddimer: { name: 'D-dimer', base: 'µg/L FEU', units: { 'µg/L FEU': 1, 'ng/mL FEU': 1, 'mg/L FEU': 1000 } },
};

/** A value in the analyte's conventional unit. */
export function toConventional(value, analyte, unit) {
    const factor = ANALYTES[analyte]?.units[unit];

    return Number.isFinite(value) && factor ? value * factor : NaN;
}

export function fromConventional(value, analyte, unit) {
    const factor = ANALYTES[analyte]?.units[unit];

    return Number.isFinite(value) && factor ? value / factor : NaN;
}

/** Every unit of an analyte for a conventional value, as "5.5 mmol/L" strings. */
export function allUnits(value, analyte, format) {
    return Object.keys(ANALYTES[analyte].units).map((unit) => `${format(fromConventional(value, analyte, unit))} ${unit}`);
}
