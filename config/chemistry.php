<?php

/*
|--------------------------------------------------------------------------
| Chemistry calculators
|--------------------------------------------------------------------------
|
| Same shape as config/biology.php. Each tool is listed once; its key,
| route name and view are derived from the category and tool slugs:
|   key        {category}::{tool}
|   route name chemistry.{category}.{tool}
|   view       chemistry.{category}.{tool with underscores}
|
*/

$categories = [
    [
        'slug' => 'general-chemistry',
        'title' => 'General Chemistry',
        'description' => 'Atoms, elements, electron configurations, molar mass and bonding',
        'tools' => [
            ['slug' => 'atom-calculator', 'title' => 'Atom Calculator', 'description' => 'Protons, neutrons and electrons'],
            ['slug' => 'atomic-mass-calculator', 'title' => 'Atomic Mass Calculator', 'description' => 'Atomic weights, isotope masses, binding energy'],
            ['slug' => 'average-atomic-mass-calculator', 'title' => 'Average Atomic Mass Calculator', 'description' => 'Weighted mean of isotopes'],
            ['slug' => 'bond-order-calculator', 'title' => 'Bond Order Calculator', 'description' => 'MO bond order and magnetism'],
            ['slug' => 'chemical-name-calculator', 'title' => 'Chemical Name Calculator', 'description' => 'Inorganic names ⇄ formulas'],
            ['slug' => 'effective-nuclear-charge-calculator', 'title' => 'Effective Nuclear Charge Calculator', 'description' => 'Zeff by Slater’s rules'],
            ['slug' => 'electron-configuration-calculator', 'title' => 'Electron Configuration Calculator', 'description' => 'Configurations, orbital boxes, practice'],
            ['slug' => 'electronegativity-calculator', 'title' => 'Electronegativity Calculator', 'description' => 'Δχ and bond type'],
            ['slug' => 'mass-concentration-to-molar-concentration', 'title' => 'Mass Concentration to Molar Concentration Conversion', 'description' => 'g/L ⇄ mol/L'],
            ['slug' => 'molar-mass-calculator', 'title' => 'Molar Mass Calculator', 'description' => 'g/mol of any formula'],
            ['slug' => 'percent-composition-calculator', 'title' => 'Percent Composition Calculator', 'description' => 'Mass % of each element'],
            ['slug' => 'percent-ionic-character-calculator', 'title' => 'Percent Ionic Character Calculator', 'description' => 'Pauling and Hannay–Smyth'],
            ['slug' => 'pka-calculator', 'title' => 'pKa Calculator', 'description' => 'Ka, pKa, pKb from data or pH'],
        ],
    ],
    [
        'slug' => 'stoichiometry',
        'title' => 'Stoichiometry',
        'description' => 'Moles, molarity, molality, formulas and reaction amounts',
        'tools' => [
            ['slug' => 'molarity-calculator', 'title' => 'Molarity Calculator', 'description' => 'Mass, concentration or volume of a solution, from a formula'],
            ['slug' => 'afr-calculator', 'title' => 'AFR Calculator (Air-Fuel Ratio)', 'description' => 'Air–fuel ratio and lambda'],
            ['slug' => 'atom-economy-calculator', 'title' => 'Atom Economy Calculator', 'description' => 'Green chemistry efficiency'],
            ['slug' => 'avogadros-number-calculator', 'title' => 'Avogadro\'s Number Calculator', 'description' => 'Moles ⇄ particles'],
            ['slug' => 'empirical-formula-calculator', 'title' => 'Empirical Formula Calculator', 'description' => 'Empirical and molecular formulas'],
            ['slug' => 'grams-to-moles-calculator', 'title' => 'Grams to Moles Calculator', 'description' => 'Mass ⇄ moles'],
            ['slug' => 'hydrogen-ion-concentration-calculator', 'title' => 'Hydrogen Ion Concentration Calculator', 'description' => 'pH ⇄ [H⁺] at any temperature'],
            ['slug' => 'molality-calculator', 'title' => 'Molality Calculator', 'description' => 'mol/kg of solvent'],
            ['slug' => 'molar-mass-of-gas-calculator', 'title' => 'Molar Mass of Gas Calculator', 'description' => 'M from PV = nRT'],
            ['slug' => 'mole-calculator', 'title' => 'Mole Calculator', 'description' => 'Moles from mass, particles, gas or solution'],
            ['slug' => 'molecular-weight-calculator', 'title' => 'Molecular Weight Calculator', 'description' => 'Average and monoisotopic mass'],
            ['slug' => 'mole-fraction-calculator', 'title' => 'Mole Fraction Calculator', 'description' => 'Mole fraction of each component'],
            ['slug' => 'moles-to-atoms-converter', 'title' => 'Moles to Atoms Converter', 'description' => 'Moles ⇄ atoms'],
            ['slug' => 'normality-calculator', 'title' => 'Normality Calculator', 'description' => 'Equivalents per liter'],
            ['slug' => 'ppm-to-molarity-calculator', 'title' => 'PPM to Molarity Calculator', 'description' => 'ppm ⇄ mol/L'],
            ['slug' => 'residence-time-calculator', 'title' => 'Residence Time Calculator', 'description' => 'τ = V ÷ Q, detention and HRT'],
        ],
    ],
    [
        'slug' => 'mixtures-and-solutions',
        'title' => 'Mixtures & Solutions',
        'description' => 'Concentrations, dilutions, pH, buffers and titrations',
        'tools' => [
            ['slug' => 'solution-dilution-calculator', 'title' => 'Solution Dilution Calculator', 'description' => 'Solve C1V1 = C2V2'],
            ['slug' => 'serial-dilution-calculator', 'title' => 'Serial Dilution Calculator', 'description' => 'Tube-by-tube dilution series'],
            ['slug' => 'buffer-ph-calculator', 'title' => 'Buffer pH Calculator (Henderson–Hasselbalch)', 'description' => 'Henderson–Hasselbalch pH and recipes'],
            ['slug' => 'percent-solution-calculator', 'title' => 'Percent Solution Calculator', 'description' => '% w/v and % v/v solutions'],
            ['slug' => 'activity-coefficient-calculator', 'title' => 'Activity Coefficient Calculator', 'description' => 'Debye–Hückel and Davies γ'],
            ['slug' => 'alligation-calculator', 'title' => 'Alligation Calculator', 'description' => 'Mix two strengths to a target'],
            ['slug' => 'bleach-dilution-calculator', 'title' => 'Bleach Dilution Calculator', 'description' => 'Bleach and water for a ppm target'],
            ['slug' => 'buffer-capacity-calculator', 'title' => 'Buffer Capacity Calculator', 'description' => 'β by Van Slyke'],
            ['slug' => 'concentration-calculator', 'title' => 'Concentration Calculator', 'description' => 'One concentration in ten units'],
            ['slug' => 'dilution-factor-calculator', 'title' => 'Dilution Factor Calculator', 'description' => 'Factor, aliquot and diluent'],
            ['slug' => 'mass-percent-calculator', 'title' => 'Mass Percent Calculator', 'description' => '% w/w, ppm and molality'],
            ['slug' => 'mixing-ratio-calculator', 'title' => 'Mixing Ratio Calculator', 'description' => 'Split a total by a ratio'],
            ['slug' => 'neutralization-calculator', 'title' => 'Neutralization Calculator', 'description' => 'Base to neutralize an acid'],
            ['slug' => 'percentage-concentration-to-molarity-calculator', 'title' => 'Percentage Concentration to Molarity Calculator', 'description' => 'Percent and density to molarity'],
            ['slug' => 'ph-calculator', 'title' => 'pH Calculator', 'description' => 'Exact pH of acids and bases'],
            ['slug' => 'raoults-law-calculator', 'title' => 'Raoult\'s Law Calculator', 'description' => 'Vapor pressure of ideal solutions'],
            ['slug' => 'reconstitution-calculator', 'title' => 'Reconstitution Calculator', 'description' => 'Concentration after dissolving a powder'],
            ['slug' => 'saponification-value-calculator', 'title' => 'Saponification Value Calculator', 'description' => 'Lye and water for soap'],
            ['slug' => 'tds-calculator', 'title' => 'TDS Calculator', 'description' => 'Total dissolved solids'],
            ['slug' => 'titration-calculator', 'title' => 'Titration Calculator', 'description' => 'Unknowns and titration curves'],
            ['slug' => 'water-hardness-calculator', 'title' => 'Water Hardness Calculator', 'description' => 'Hardness in every unit'],
            ['slug' => 'solubility-product-calculator', 'title' => 'Solubility Product (Ksp) Calculator', 'description' => 'Ksp and molar solubility'],
        ],
    ],
    [
        'slug' => 'chemical-reactions',
        'title' => 'Chemical Reactions',
        'description' => 'Balancing, yields, equilibrium and reaction rates',
        'tools' => [
            ['slug' => 'chemical-equation-balancer', 'title' => 'Chemical Equation Balancer', 'description' => 'Exact balancing, ions and redox'],
            ['slug' => 'net-ionic-equation-calculator', 'title' => 'Net Ionic Equation Calculator', 'description' => 'Complete and net ionic equations'],
            ['slug' => 'molar-ratio-calculator', 'title' => 'Molar Ratio Calculator', 'description' => 'Mole ratios and amounts'],
            ['slug' => 'theoretical-yield-calculator', 'title' => 'Theoretical Yield Calculator', 'description' => 'Maximum product and limiting reactant'],
            ['slug' => 'limiting-reactant-calculator', 'title' => 'Limiting Reactant Calculator', 'description' => 'What runs out and what is left'],
            ['slug' => 'percent-yield-calculator', 'title' => 'Percent Yield Calculator', 'description' => 'Actual ÷ theoretical'],
            ['slug' => 'actual-yield-calculator', 'title' => 'Actual Yield Calculator', 'description' => 'Expected product from % yield'],
            ['slug' => 'equilibrium-constant-calculator', 'title' => 'Equilibrium Constant Calculator', 'description' => 'K and ICE tables'],
            ['slug' => 'kp-calculator', 'title' => 'Kp Calculator', 'description' => 'Kc ⇄ Kp'],
            ['slug' => 'reaction-quotient-calculator', 'title' => 'Reaction Quotient Calculator', 'description' => 'Q and reaction direction'],
            ['slug' => 'rate-constant-calculator', 'title' => 'Rate Constant Calculator', 'description' => 'k for zero, first, second order'],
            ['slug' => 'arrhenius-equation-calculator', 'title' => 'Arrhenius Equation Calculator', 'description' => 'Solve k = A e^(−Ea/RT)'],
            ['slug' => 'activation-energy-calculator', 'title' => 'Activation Energy Calculator', 'description' => 'Ea from two temperatures'],
        ],
    ],
    [
        'slug' => 'thermodynamics',
        'title' => 'Thermodynamics',
        'description' => 'Boiling and freezing points, vapor pressure, enthalpy, entropy and Gibbs energy',
        'tools' => [
            ['slug' => 'boiling-point-calculator', 'title' => 'Boiling Point Calculator', 'description' => 'Boiling point at any pressure'],
            ['slug' => 'boiling-point-at-altitude-calculator', 'title' => 'Boiling Point at Altitude Calculator', 'description' => 'Water’s boiling point by altitude'],
            ['slug' => 'boiling-point-elevation-calculator', 'title' => 'Boiling Point Elevation Calculator', 'description' => 'ΔTb = i Kb m'],
            ['slug' => 'freezing-point-depression-calculator', 'title' => 'Freezing Point Depression Calculator', 'description' => 'ΔTf = i Kf m'],
            ['slug' => 'entropy-calculator', 'title' => 'Entropy Calculator', 'description' => 'ΔS for reactions and processes'],
            ['slug' => 'gibbs-free-energy-calculator', 'title' => 'Gibbs Free Energy Calculator', 'description' => 'ΔG and spontaneity'],
            ['slug' => 'gibbs-phase-rule-calculator', 'title' => 'Gibbs\' Phase Rule Calculator', 'description' => 'F = C − P + 2'],
            ['slug' => 'heat-of-combustion-calculator', 'title' => 'Heat of Combustion Calculator', 'description' => 'ΔHc, HHV and LHV'],
            ['slug' => 'q10-calculator', 'title' => 'Q10 Calculator', 'description' => 'Temperature coefficient'],
            ['slug' => 'stp-calculator', 'title' => 'STP Calculator (Standard Temperature and Pressure)', 'description' => 'Gas volume at STP'],
            ['slug' => 'vapor-pressure-calculator', 'title' => 'Vapor Pressure Calculator', 'description' => 'Vapor pressure of 30 liquids'],
            ['slug' => 'vapor-pressure-of-water-calculator', 'title' => 'Vapor Pressure of Water Calculator', 'description' => 'IAPWS water and ice'],
            ['slug' => 'enthalpy-of-reaction-calculator', 'title' => 'Enthalpy of Reaction Calculator', 'description' => 'Hess’s law ΔH°'],
            ['slug' => 'specific-heat-calculator', 'title' => 'Specific Heat Calculator', 'description' => 'q = mcΔT and calorimetry'],
        ],
    ],
    [
        'slug' => 'electrochemistry',
        'title' => 'Electrochemistry',
        'description' => 'Cell potentials, electrolysis, ionic strength and lattice energy',
        'tools' => [
            ['slug' => 'cell-emf-calculator', 'title' => 'Cell EMF Calculator', 'description' => 'E°cell, Ecell, ΔG° and K'],
            ['slug' => 'electrolysis-calculator', 'title' => 'Electrolysis Calculator', 'description' => 'Faraday’s laws'],
            ['slug' => 'ionic-strength-calculator', 'title' => 'Ionic Strength Calculator', 'description' => 'I = ½ Σ c z²'],
            ['slug' => 'lattice-energy-calculator', 'title' => 'Lattice Energy Calculator', 'description' => 'Born–Haber cycle'],
            ['slug' => 'nernst-equation-calculator', 'title' => 'Nernst Equation Calculator', 'description' => 'E away from standard conditions'],
        ],
    ],
    [
        'slug' => 'physical-chemistry',
        'title' => 'Physical Chemistry',
        'description' => 'Gas laws, decay, diffusion, absorbance, surfaces and crystals',
        'tools' => [
            ['slug' => 'beer-lambert-law-calculator', 'title' => 'Beer–Lambert Law Calculator', 'description' => 'Solve A = εcl'],
            ['slug' => 'ideal-gas-law-calculator', 'title' => 'Ideal Gas Law Calculator', 'description' => 'Solve PV = nRT'],
            ['slug' => 'combined-gas-law-calculator', 'title' => 'Combined Gas Law Calculator', 'description' => 'Boyle, Charles and Gay-Lussac'],
            ['slug' => 'van-der-waals-equation-calculator', 'title' => 'Van der Waals Equation Calculator', 'description' => 'Real-gas P, V or T'],
            ['slug' => 'rate-of-effusion-calculator', 'title' => 'Rate of Effusion Calculator', 'description' => 'Graham’s law'],
            ['slug' => 'diffusion-coefficient-calculator', 'title' => 'Diffusion Coefficient Calculator', 'description' => 'Stokes–Einstein D'],
            ['slug' => 'half-life-calculator', 'title' => 'Half-Life Calculator', 'description' => 'Any first-order decay'],
            ['slug' => 'radioactive-decay-calculator', 'title' => 'Radioactive Decay Calculator', 'description' => '24 isotopes, NUBASE2020'],
            ['slug' => 'langmuir-isotherm-calculator', 'title' => 'Langmuir Isotherm Calculator', 'description' => 'Coverage and data fits'],
            ['slug' => 'osmotic-pressure-calculator', 'title' => 'Osmotic Pressure Calculator', 'description' => 'Π = iMRT'],
            ['slug' => 'partial-pressure-calculator', 'title' => 'Partial Pressure Calculator', 'description' => 'Dalton’s law'],
            ['slug' => 'two-photon-absorption-calculator', 'title' => 'Two-Photon Absorption Calculator', 'description' => 'β ⇄ σ₂ in GM'],
            ['slug' => 'young-laplace-equation-calculator', 'title' => 'Young-Laplace Equation Calculator', 'description' => 'Pressure in drops and bubbles'],
            ['slug' => 'cubic-cell-calculator', 'title' => 'Cubic Cell Calculator', 'description' => 'Unit cell density and packing'],
            ['slug' => 'miller-indices-calculator', 'title' => 'Miller Indices Calculator', 'description' => '(hkl), d-spacing, Bragg angle'],
            ['slug' => 'photon-energy-calculator', 'title' => 'Photon Energy Calculator', 'description' => 'Wavelength ⇄ energy, Rydberg'],
            ['slug' => 'de-broglie-wavelength-calculator', 'title' => 'de Broglie Wavelength Calculator', 'description' => 'Matter wavelength'],
            ['slug' => 'henrys-law-calculator', 'title' => 'Henry\'s Law Calculator', 'description' => 'Dissolved gas in water'],
        ],
    ],
    [
        'slug' => 'organic-chemistry',
        'title' => 'Organic Chemistry',
        'description' => 'Combustion, unsaturation, oxygen demand and radiocarbon dating',
        'tools' => [
            ['slug' => 'chemical-oxygen-demand-calculator', 'title' => 'Chemical Oxygen Demand Calculator', 'description' => 'COD and ThOD'],
            ['slug' => 'combustion-analysis-calculator', 'title' => 'Combustion Analysis Calculator', 'description' => 'Formula from CO₂ and H₂O'],
            ['slug' => 'combustion-reaction-calculator', 'title' => 'Combustion Reaction Calculator', 'description' => 'Balanced complete combustion'],
            ['slug' => 'crude-protein-calculator', 'title' => 'Crude Protein Calculator', 'description' => 'Nitrogen × Jones factor'],
            ['slug' => 'degree-of-unsaturation-calculator', 'title' => 'Degree of Unsaturation Calculator', 'description' => 'Rings + π bonds (DBE)'],
            ['slug' => 'liquid-ethylene-density-calculator', 'title' => 'Liquid Ethylene Density Calculator', 'description' => 'NIST saturated-liquid density'],
            ['slug' => 'radiocarbon-dating-calculator', 'title' => 'Radiocarbon Dating Calculator (Carbon 14 Dating)', 'description' => 'Radiocarbon age from ¹⁴C'],
        ],
    ],
    [
        'slug' => 'biochemistry',
        'title' => 'Biochemistry',
        'description' => 'Calibration curves, enzymes and protein charge',
        'tools' => [
            ['slug' => 'calibration-curve-calculator', 'title' => 'Calibration Curve Calculator', 'description' => 'Line, R², LOD, LOQ'],
            ['slug' => 'enzyme-activity-calculator', 'title' => 'Enzyme Activity Calculator', 'description' => 'U/mL and specific activity'],
            ['slug' => 'isoelectric-point-calculator', 'title' => 'Isoelectric Point Calculator', 'description' => 'Protein pI and charge'],
            ['slug' => 'michaelis-menten-equation-calculator', 'title' => 'Michaelis-Menten Equation Calculator', 'description' => 'Vmax, Km and kcat'],
        ],
    ],
];

$calculators = [];

foreach ($categories as &$category) {
    foreach ($category['tools'] as &$tool) {
        $tool['key'] = "{$category['slug']}::{$tool['slug']}";
        $tool['route_name'] = "chemistry.{$category['slug']}.{$tool['slug']}";
        $tool['view'] = "chemistry.{$category['slug']}.".str_replace('-', '_', $tool['slug']);
        $tool['category_slug'] = $category['slug'];
        $calculators[$tool['key']] = $tool;
    }
    unset($tool);
}
unset($category);

return [
    'categories' => $categories,
    'calculators' => $calculators,
];
