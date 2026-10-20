<?php

/*
|--------------------------------------------------------------------------
| Physics reference data
|--------------------------------------------------------------------------
|
| Read by the Physics section tools (resources/js/calc/tools/ph-*.js) through
| the page's `data` config. Each block names its source; values are in SI
| unless the key says otherwise.
|
*/

return [

    /*
    | Solar-system bodies. GM (km³/s²) and mean radius (km): NASA/JPL Solar System
    | Dynamics, Planetary Physical Parameters and Planetary Satellite Physical
    | Parameters (ssd.jpl.nasa.gov, accessed 2026). Orbit: semi-major axis (AU) and
    | sidereal period (days), NASA Planetary Fact Sheet; the Moon's orbit is around
    | the Earth (384,400 km, 27.3217 d). Surface gravity is computed as GM/r² at the
    | mean radius, without rotation.
    */
    'bodies' => [
        'sun' => ['name' => 'Sun', 'gm' => 132712440041.94, 'radius' => 695700, 'a_au' => null, 'period_d' => null],
        'mercury' => ['name' => 'Mercury', 'gm' => 22031.86855, 'radius' => 2439.4, 'a_au' => 0.387098, 'period_d' => 87.969],
        'venus' => ['name' => 'Venus', 'gm' => 324858.592, 'radius' => 6051.8, 'a_au' => 0.723332, 'period_d' => 224.701],
        'earth' => ['name' => 'Earth', 'gm' => 398600.435436, 'radius' => 6371.0084, 'a_au' => 1.000001, 'period_d' => 365.256],
        'moon' => ['name' => 'Moon', 'gm' => 4902.800066, 'radius' => 1737.4, 'a_au' => null, 'period_d' => 27.3217, 'orbit_km' => 384400],
        'mars' => ['name' => 'Mars', 'gm' => 42828.375214, 'radius' => 3389.5, 'a_au' => 1.523679, 'period_d' => 686.980],
        'ceres' => ['name' => 'Ceres', 'gm' => 62.6284, 'radius' => 469.7, 'a_au' => 2.7675, 'period_d' => 1680.1],
        'jupiter' => ['name' => 'Jupiter', 'gm' => 126686531.9, 'radius' => 69911, 'a_au' => 5.2044, 'period_d' => 4332.59],
        'io' => ['name' => 'Io', 'gm' => 5959.916, 'radius' => 1821.6, 'a_au' => null, 'period_d' => 1.769],
        'europa' => ['name' => 'Europa', 'gm' => 3202.739, 'radius' => 1560.8, 'a_au' => null, 'period_d' => 3.551],
        'ganymede' => ['name' => 'Ganymede', 'gm' => 9887.834, 'radius' => 2631.2, 'a_au' => null, 'period_d' => 7.155],
        'saturn' => ['name' => 'Saturn', 'gm' => 37931206.2, 'radius' => 58232, 'a_au' => 9.5826, 'period_d' => 10759.22],
        'titan' => ['name' => 'Titan', 'gm' => 8978.14, 'radius' => 2574.7, 'a_au' => null, 'period_d' => 15.945],
        'uranus' => ['name' => 'Uranus', 'gm' => 5793951.3, 'radius' => 25362, 'a_au' => 19.2184, 'period_d' => 30688.5],
        'neptune' => ['name' => 'Neptune', 'gm' => 6835099.97, 'radius' => 24622, 'a_au' => 30.110, 'period_d' => 60195],
        'pluto' => ['name' => 'Pluto', 'gm' => 869.6, 'radius' => 1188.3, 'a_au' => 39.482, 'period_d' => 90560],
    ],

    /*
    | Refractive index n at 589 nm (sodium D line), about 20 °C. Sources: CRC Handbook
    | of Chemistry and Physics; refractiveindex.info (Schott N-BK7, fused silica Malitson
    | 1965, sapphire ordinary ray). Values vary slightly with wavelength and grade.
    */
    'refractive' => [
        'vacuum' => ['name' => 'Vacuum', 'n' => 1],
        'air' => ['name' => 'Air (15 °C, 1 atm)', 'n' => 1.000277],
        'water' => ['name' => 'Water', 'n' => 1.3330],
        'ice' => ['name' => 'Ice', 'n' => 1.309],
        'ethanol' => ['name' => 'Ethanol', 'n' => 1.3614],
        'glycerol' => ['name' => 'Glycerol', 'n' => 1.4729],
        'silica' => ['name' => 'Fused silica (quartz glass)', 'n' => 1.4585],
        'acrylic' => ['name' => 'Acrylic (PMMA)', 'n' => 1.4905],
        'bk7' => ['name' => 'Crown glass (N-BK7)', 'n' => 1.5168],
        'polycarbonate' => ['name' => 'Polycarbonate', 'n' => 1.5849],
        'flint' => ['name' => 'Dense flint glass (SF2)', 'n' => 1.6477],
        'sapphire' => ['name' => 'Sapphire', 'n' => 1.7682],
        'zirconia' => ['name' => 'Cubic zirconia', 'n' => 2.17],
        'diamond' => ['name' => 'Diamond', 'n' => 2.4175],
    ],

    /*
    | Sound in fluids. Gases: ratio of specific heats γ and molar mass M (g/mol), with
    | c = √(γRT/M) at any temperature (ideal gas). Liquids: speed (m/s) and density
    | (kg/m³) at 20–25 °C (CRC Handbook; Kaye & Laby). Sea water: 35 ‰, 20 °C.
    */
    'sound_media' => [
        'air' => ['name' => 'Air (dry)', 'gamma' => 1.4, 'molar' => 28.9647],
        'nitrogen' => ['name' => 'Nitrogen', 'gamma' => 1.4, 'molar' => 28.0134],
        'oxygen' => ['name' => 'Oxygen', 'gamma' => 1.395, 'molar' => 31.998],
        'helium' => ['name' => 'Helium', 'gamma' => 1.6667, 'molar' => 4.0026],
        'hydrogen' => ['name' => 'Hydrogen', 'gamma' => 1.405, 'molar' => 2.016],
        'co2' => ['name' => 'Carbon dioxide', 'gamma' => 1.289, 'molar' => 44.01],
        'methane' => ['name' => 'Methane', 'gamma' => 1.304, 'molar' => 16.043],
        'water' => ['name' => 'Fresh water (20 °C)', 'speed' => 1482, 'density' => 998],
        'seawater' => ['name' => 'Sea water (20 °C)', 'speed' => 1522, 'density' => 1025],
        'ethanol' => ['name' => 'Ethanol (25 °C)', 'speed' => 1143, 'density' => 785],
        'glycerol' => ['name' => 'Glycerol (25 °C)', 'speed' => 1904, 'density' => 1260],
        'mercury' => ['name' => 'Mercury (25 °C)', 'speed' => 1450, 'density' => 13534],
    ],

    /*
    | Isotropic solids: Young's modulus E (GPa), density (kg/m³) and Poisson's ratio,
    | typical room-temperature handbook values (ASM; CRC; Engineering Toolbox). Wood is
    | anisotropic; the value is along the grain.
    */
    'solids' => [
        'steel' => ['name' => 'Structural steel', 'E' => 200, 'density' => 7850, 'nu' => 0.29],
        'stainless' => ['name' => 'Stainless steel 304', 'E' => 193, 'density' => 8000, 'nu' => 0.29],
        'aluminium' => ['name' => 'Aluminium alloy 6061', 'E' => 68.9, 'density' => 2700, 'nu' => 0.33],
        'copper' => ['name' => 'Copper', 'E' => 117, 'density' => 8960, 'nu' => 0.34],
        'brass' => ['name' => 'Brass', 'E' => 100, 'density' => 8500, 'nu' => 0.34],
        'titanium' => ['name' => 'Titanium (Ti-6Al-4V)', 'E' => 114, 'density' => 4430, 'nu' => 0.34],
        'lead' => ['name' => 'Lead', 'E' => 16, 'density' => 11340, 'nu' => 0.44],
        'glass' => ['name' => 'Soda-lime glass', 'E' => 72, 'density' => 2500, 'nu' => 0.22],
        'concrete' => ['name' => 'Concrete', 'E' => 30, 'density' => 2400, 'nu' => 0.2],
        'granite' => ['name' => 'Granite', 'E' => 50, 'density' => 2700, 'nu' => 0.25],
        'oak' => ['name' => 'Oak (along the grain)', 'E' => 11, 'density' => 750, 'nu' => 0.35],
        'nylon' => ['name' => 'Nylon 6/6', 'E' => 2.9, 'density' => 1140, 'nu' => 0.39],
    ],

    /*
    | Sound absorption coefficients at 125, 250, 500, 1000, 2000 and 4000 Hz: typical
    | published values (Long, Architectural Acoustics, 2nd ed., Appendix; Egan,
    | Architectural Acoustics). Products differ, so use maker data for design.
    */
    'absorption' => [
        'concrete' => ['name' => 'Concrete, smooth unpainted', 'a' => [0.01, 0.01, 0.02, 0.02, 0.02, 0.03]],
        'block_painted' => ['name' => 'Concrete block, painted', 'a' => [0.10, 0.05, 0.06, 0.07, 0.09, 0.08]],
        'brick' => ['name' => 'Brick, unglazed', 'a' => [0.03, 0.03, 0.03, 0.04, 0.05, 0.07]],
        'plaster' => ['name' => 'Plaster on brick or block', 'a' => [0.013, 0.015, 0.02, 0.03, 0.04, 0.05]],
        'gypsum' => ['name' => 'Gypsum board on studs', 'a' => [0.29, 0.10, 0.05, 0.04, 0.07, 0.09]],
        'glass' => ['name' => 'Window glass', 'a' => [0.35, 0.25, 0.18, 0.12, 0.07, 0.04]],
        'wood_floor' => ['name' => 'Wood floor', 'a' => [0.15, 0.11, 0.10, 0.07, 0.06, 0.07]],
        'wood_panel' => ['name' => 'Wood panelling on battens', 'a' => [0.28, 0.22, 0.17, 0.09, 0.10, 0.11]],
        'vinyl' => ['name' => 'Vinyl or linoleum on concrete', 'a' => [0.02, 0.03, 0.03, 0.03, 0.03, 0.02]],
        'carpet_concrete' => ['name' => 'Carpet on concrete', 'a' => [0.02, 0.06, 0.14, 0.37, 0.60, 0.65]],
        'carpet_pad' => ['name' => 'Carpet on foam underlay', 'a' => [0.08, 0.24, 0.57, 0.69, 0.71, 0.73]],
        'ceiling_tile' => ['name' => 'Acoustic ceiling tile (suspended)', 'a' => [0.70, 0.66, 0.72, 0.92, 0.88, 0.75]],
        'curtains' => ['name' => 'Heavy curtains, pleated', 'a' => [0.14, 0.35, 0.55, 0.72, 0.70, 0.65]],
        'fibreglass' => ['name' => 'Fibreglass board, 50 mm', 'a' => [0.18, 0.76, 0.99, 0.99, 0.99, 0.99]],
        'seats' => ['name' => 'Upholstered seats (per m² of seating)', 'a' => [0.19, 0.37, 0.56, 0.67, 0.61, 0.59]],
        'water' => ['name' => 'Water surface (pool)', 'a' => [0.008, 0.008, 0.013, 0.015, 0.020, 0.025]],
    ],

    /*
    | Engineering materials: Young's modulus E (GPa), Poisson's ratio, yield and
    | ultimate tensile strength (MPa), density (kg/m³) and linear thermal expansion
    | α (10⁻⁶/K). Typical room-temperature values (MatWeb; ASM Handbook; ASTM A36,
    | AA 6061-T6). Brittle materials have no yield (null); concrete strength is in
    | compression. Grades vary, so use certified values for design.
    */
    'materials' => [
        'a36' => ['name' => 'Structural steel (A36)', 'E' => 200, 'nu' => 0.26, 'yield' => 250, 'uts' => 400, 'density' => 7850, 'alpha' => 11.7],
        'steel_4140' => ['name' => 'Alloy steel 4140 (quenched and tempered)', 'E' => 205, 'nu' => 0.29, 'yield' => 655, 'uts' => 1020, 'density' => 7850, 'alpha' => 12.2],
        'ss304' => ['name' => 'Stainless steel 304 (annealed)', 'E' => 193, 'nu' => 0.29, 'yield' => 215, 'uts' => 505, 'density' => 8000, 'alpha' => 17.3],
        'al6061' => ['name' => 'Aluminium 6061-T6', 'E' => 68.9, 'nu' => 0.33, 'yield' => 276, 'uts' => 310, 'density' => 2700, 'alpha' => 23.6],
        'al7075' => ['name' => 'Aluminium 7075-T6', 'E' => 71.7, 'nu' => 0.33, 'yield' => 503, 'uts' => 572, 'density' => 2810, 'alpha' => 23.6],
        'copper' => ['name' => 'Copper (annealed)', 'E' => 117, 'nu' => 0.34, 'yield' => 70, 'uts' => 220, 'density' => 8960, 'alpha' => 16.5],
        'brass' => ['name' => 'Brass C360 (free-cutting)', 'E' => 97, 'nu' => 0.31, 'yield' => 310, 'uts' => 385, 'density' => 8500, 'alpha' => 20.5],
        'ti64' => ['name' => 'Titanium Ti-6Al-4V', 'E' => 113.8, 'nu' => 0.342, 'yield' => 880, 'uts' => 950, 'density' => 4430, 'alpha' => 8.6],
        'cast_iron' => ['name' => 'Grey cast iron (class 30)', 'E' => 100, 'nu' => 0.26, 'yield' => null, 'uts' => 214, 'density' => 7200, 'alpha' => 10.8],
        'concrete' => ['name' => 'Concrete (30 MPa)', 'E' => 30, 'nu' => 0.2, 'yield' => null, 'uts' => 30, 'density' => 2400, 'alpha' => 10],
        'glass' => ['name' => 'Soda-lime glass', 'E' => 72, 'nu' => 0.22, 'yield' => null, 'uts' => 45, 'density' => 2500, 'alpha' => 9],
        'nylon' => ['name' => 'Nylon 6/6', 'E' => 2.9, 'nu' => 0.39, 'yield' => 70, 'uts' => 80, 'density' => 1140, 'alpha' => 80],
        'pvc' => ['name' => 'Rigid PVC', 'E' => 3.2, 'nu' => 0.4, 'yield' => 45, 'uts' => 50, 'density' => 1400, 'alpha' => 52],
        'oak' => ['name' => 'Oak (along the grain)', 'E' => 11, 'nu' => 0.35, 'yield' => null, 'uts' => 90, 'density' => 750, 'alpha' => 5],
    ],

    /*
    | Densities (kg/m³) at about 20 °C, typical values (CRC Handbook; Engineering
    | Toolbox). Natural materials and fuels vary by a few percent.
    */
    'densities' => [
        'water' => ['name' => 'Water', 'density' => 998.2],
        'seawater' => ['name' => 'Sea water', 'density' => 1025],
        'ice' => ['name' => 'Ice (0 °C)', 'density' => 917],
        'petrol' => ['name' => 'Petrol (gasoline)', 'density' => 745],
        'diesel' => ['name' => 'Diesel', 'density' => 832],
        'ethanol' => ['name' => 'Ethanol', 'density' => 789],
        'olive_oil' => ['name' => 'Olive oil', 'density' => 911],
        'milk' => ['name' => 'Milk', 'density' => 1030],
        'honey' => ['name' => 'Honey', 'density' => 1420],
        'mercury' => ['name' => 'Mercury', 'density' => 13534],
        'air' => ['name' => 'Air (20 °C, 1 atm)', 'density' => 1.204],
        'steel' => ['name' => 'Steel', 'density' => 7850],
        'stainless' => ['name' => 'Stainless steel', 'density' => 8000],
        'aluminium' => ['name' => 'Aluminium', 'density' => 2700],
        'copper' => ['name' => 'Copper', 'density' => 8960],
        'brass' => ['name' => 'Brass', 'density' => 8500],
        'lead' => ['name' => 'Lead', 'density' => 11340],
        'titanium' => ['name' => 'Titanium', 'density' => 4506],
        'gold' => ['name' => 'Gold', 'density' => 19320],
        'silver' => ['name' => 'Silver', 'density' => 10490],
        'concrete' => ['name' => 'Concrete', 'density' => 2400],
        'glass' => ['name' => 'Glass', 'density' => 2500],
        'granite' => ['name' => 'Granite', 'density' => 2700],
        'sand' => ['name' => 'Dry sand (loose)', 'density' => 1600],
        'pine' => ['name' => 'Pine wood', 'density' => 500],
        'oak' => ['name' => 'Oak wood', 'density' => 750],
        'hdpe' => ['name' => 'Polyethylene (HDPE)', 'density' => 955],
        'pvc' => ['name' => 'PVC', 'density' => 1400],
    ],

    /*
    | Gold alloys by karat: density (kg/m³) and gold mass fraction. Densities are
    | typical for yellow gold (World Gold Council, Jewellery Technology); white and
    | rose alloys differ by up to about 5%.
    */
    'gold' => [
        'k24' => ['name' => '24 karat (99.9%)', 'density' => 19320, 'fraction' => 0.999],
        'k22' => ['name' => '22 karat (91.6%)', 'density' => 17800, 'fraction' => 0.9167],
        'k18' => ['name' => '18 karat (75%)', 'density' => 15600, 'fraction' => 0.75],
        'k14' => ['name' => '14 karat (58.5%)', 'density' => 13100, 'fraction' => 0.585],
        'k10' => ['name' => '10 karat (41.7%)', 'density' => 11600, 'fraction' => 0.4167],
        'k9' => ['name' => '9 karat (37.5%)', 'density' => 11200, 'fraction' => 0.375],
    ],

    /*
    | Semiconductors: band gap at 0 K (eV) with Varshni parameters α (eV/K) and β (K),
    | and effective densities of states N_c, N_v at 300 K (cm⁻³), scaled as T^1.5.
    | Sources: Sze & Ng, Physics of Semiconductor Devices, 3rd ed.; Varshni (1967)
    | fits from Ioffe Institute NSM data.
    */
    'semiconductors' => [
        'si' => ['name' => 'Silicon', 'eg0' => 1.17, 'alpha' => 4.73e-4, 'beta' => 636, 'nc' => 2.86e19, 'nv' => 2.66e19],
        'ge' => ['name' => 'Germanium', 'eg0' => 0.7437, 'alpha' => 4.774e-4, 'beta' => 235, 'nc' => 1.04e19, 'nv' => 6.0e18],
        'gaas' => ['name' => 'Gallium arsenide', 'eg0' => 1.519, 'alpha' => 5.405e-4, 'beta' => 204, 'nc' => 4.7e17, 'nv' => 9.0e18],
    ],

    /*
    | Spring wire: shear modulus G and Young's modulus E (GPa), from the Spring
    | Manufacturers Institute and Shigley's Mechanical Engineering Design, Table 10-5.
    */
    'spring_wire' => [
        'music' => ['name' => 'Music wire (ASTM A228)', 'G' => 81.7, 'E' => 203.4],
        'oil_tempered' => ['name' => 'Oil-tempered (A229)', 'G' => 77.2, 'E' => 196.5],
        'hard_drawn' => ['name' => 'Hard-drawn steel (A227)', 'G' => 80.0, 'E' => 196.5],
        'chrome_silicon' => ['name' => 'Chrome-silicon (A401)', 'G' => 77.2, 'E' => 203.4],
        'stainless302' => ['name' => 'Stainless 302 (A313)', 'G' => 69.0, 'E' => 193],
        'phosphor_bronze' => ['name' => 'Phosphor bronze (B159)', 'G' => 41.4, 'E' => 103.4],
    ],

    /*
    | Cutting speeds in surface feet per minute for milling and drilling, [HSS, carbide].
    | Starting values from Machinery's Handbook speed tables, rounded; adjust for
    | rigidity, coolant and tool coating.
    */
    'cutting' => [
        'aluminium' => ['name' => 'Aluminium alloys', 'sfm' => [300, 900]],
        'brass' => ['name' => 'Brass and bronze', 'sfm' => [200, 600]],
        'mild_steel' => ['name' => 'Mild steel (1018)', 'sfm' => [100, 400]],
        'alloy_steel' => ['name' => 'Alloy steel (4140, annealed)', 'sfm' => [70, 300]],
        'stainless' => ['name' => 'Stainless steel (304)', 'sfm' => [50, 250]],
        'cast_iron' => ['name' => 'Grey cast iron', 'sfm' => [80, 300]],
        'titanium' => ['name' => 'Titanium alloys', 'sfm' => [40, 150]],
        'plastic' => ['name' => 'Plastics (acrylic, nylon, acetal)', 'sfm' => [300, 800]],
    ],

    /*
    | Conductors: resistivity ρ at 20 °C (Ω·m), temperature coefficient α (1/K),
    | relative permeability and free-electron density n (m⁻³, where one applies).
    | Sources: CRC Handbook (resistivity, α); IEC 60028 annealed copper (1.7241 × 10⁻⁸);
    | Ashcroft & Mermin Table 1.1 (n). Alloys vary by composition.
    */
    'conductors' => [
        'copper' => ['name' => 'Copper (annealed)', 'rho' => 1.7241e-8, 'alpha' => 0.00393, 'mu' => 1, 'n' => 8.47e28],
        'aluminium' => ['name' => 'Aluminium (EC grade)', 'rho' => 2.82e-8, 'alpha' => 0.00403, 'mu' => 1, 'n' => 18.1e28],
        'silver' => ['name' => 'Silver', 'rho' => 1.59e-8, 'alpha' => 0.0038, 'mu' => 1, 'n' => 5.86e28],
        'gold' => ['name' => 'Gold', 'rho' => 2.44e-8, 'alpha' => 0.0034, 'mu' => 1, 'n' => 5.90e28],
        'tungsten' => ['name' => 'Tungsten', 'rho' => 5.6e-8, 'alpha' => 0.0045, 'mu' => 1, 'n' => null],
        'brass' => ['name' => 'Brass', 'rho' => 7.0e-8, 'alpha' => 0.0015, 'mu' => 1, 'n' => null],
        'iron' => ['name' => 'Iron (pure)', 'rho' => 9.71e-8, 'alpha' => 0.00651, 'mu' => 5000, 'n' => null],
        'steel' => ['name' => 'Carbon steel', 'rho' => 1.43e-7, 'alpha' => 0.003, 'mu' => 100, 'n' => null],
        'stainless' => ['name' => 'Stainless steel 304', 'rho' => 6.9e-7, 'alpha' => 0.00094, 'mu' => 1.02, 'n' => null],
        'constantan' => ['name' => 'Constantan', 'rho' => 4.9e-7, 'alpha' => 0.000008, 'mu' => 1, 'n' => null],
        'nichrome' => ['name' => 'Nichrome (80/20)', 'rho' => 1.10e-6, 'alpha' => 0.0004, 'mu' => 1, 'n' => null],
    ],

    /*
    | Relative permittivity (dielectric constant) at low frequency and room
    | temperature, typical values (CRC Handbook; capacitor maker data). Ceramics such
    | as barium titanate vary enormously with grade.
    */
    'dielectrics' => [
        'vacuum' => ['name' => 'Vacuum', 'er' => 1],
        'air' => ['name' => 'Air', 'er' => 1.0006],
        'ptfe' => ['name' => 'PTFE (Teflon)', 'er' => 2.1],
        'polypropylene' => ['name' => 'Polypropylene', 'er' => 2.2],
        'polyethylene' => ['name' => 'Polyethylene', 'er' => 2.25],
        'polystyrene' => ['name' => 'Polystyrene', 'er' => 2.6],
        'polyester' => ['name' => 'Polyester (PET film)', 'er' => 3.3],
        'paper' => ['name' => 'Paper (dry)', 'er' => 3.5],
        'fr4' => ['name' => 'FR-4 circuit board', 'er' => 4.4],
        'glass' => ['name' => 'Glass', 'er' => 6],
        'mica' => ['name' => 'Mica', 'er' => 6],
        'alumina' => ['name' => 'Alumina ceramic', 'er' => 9.8],
        'tantalum' => ['name' => 'Tantalum pentoxide', 'er' => 27],
        'water' => ['name' => 'Water (20 °C)', 'er' => 80.1],
        'batio3' => ['name' => 'Barium titanate (typical)', 'er' => 1200],
    ],

    /*
    | Relative permeability μ_r, typical maximum or initial values (Kaye & Laby;
    | maker data). Ferromagnetic values depend strongly on field strength and grade.
    */
    'permeability' => [
        'vacuum' => ['name' => 'Vacuum or air', 'mur' => 1],
        'copper' => ['name' => 'Copper', 'mur' => 0.999994],
        'aluminium' => ['name' => 'Aluminium', 'mur' => 1.000022],
        'water' => ['name' => 'Water', 'mur' => 0.999992],
        'nickel' => ['name' => 'Nickel', 'mur' => 600],
        'carbon_steel' => ['name' => 'Carbon steel', 'mur' => 100],
        'electrical_steel' => ['name' => 'Electrical (silicon) steel', 'mur' => 4000],
        'iron' => ['name' => 'Iron (99.8% pure)', 'mur' => 5000],
        'ferrite' => ['name' => 'Manganese-zinc ferrite', 'mur' => 2000],
        'permalloy' => ['name' => 'Permalloy', 'mur' => 8000],
        'mumetal' => ['name' => 'Mu-metal', 'mur' => 50000],
    ],

    /*
    | Luminous efficacy of light sources (lm/W, whole lamp), typical values
    | (US DOE lighting fact sheets; IEA 4E). Individual products vary widely.
    */
    'lamps' => [
        'incandescent' => ['name' => 'Incandescent', 'efficacy' => 14],
        'halogen' => ['name' => 'Halogen', 'efficacy' => 18],
        'cfl' => ['name' => 'Compact fluorescent', 'efficacy' => 60],
        'fluorescent' => ['name' => 'Fluorescent tube (T5/T8)', 'efficacy' => 85],
        'metal_halide' => ['name' => 'Metal halide', 'efficacy' => 85],
        'hps' => ['name' => 'High-pressure sodium', 'efficacy' => 110],
        'led' => ['name' => 'LED', 'efficacy' => 100],
    ],

    /*
    | Typical LED forward voltage (V) at about 20 mA by colour (maker data sheets,
    | e.g. Kingbright, Cree). Check the data sheet for the exact value.
    */
    'leds' => [
        'red' => ['name' => 'Red', 'vf' => 2.0],
        'orange' => ['name' => 'Orange', 'vf' => 2.1],
        'yellow' => ['name' => 'Yellow', 'vf' => 2.1],
        'green' => ['name' => 'Green (standard)', 'vf' => 2.2],
        'true_green' => ['name' => 'Green (InGaN, bright)', 'vf' => 3.2],
        'blue' => ['name' => 'Blue', 'vf' => 3.2],
        'white' => ['name' => 'White', 'vf' => 3.2],
        'infrared' => ['name' => 'Infrared', 'vf' => 1.3],
    ],

    /*
    | Fluids at 20 °C and 1 atm: density (kg/m³), dynamic viscosity (Pa·s),
    | specific heat c_p (J/(kg·K)) and thermal conductivity (W/(m·K)).
    | Sources: CRC Handbook; Incropera, Fundamentals of Heat and Mass Transfer,
    | Appendix A; Engineering Toolbox for oils and food liquids (typical values).
    */
    'fluids' => [
        'water' => ['name' => 'Water', 'density' => 998.2, 'mu' => 1.002e-3, 'cp' => 4182, 'k' => 0.598],
        'seawater' => ['name' => 'Sea water', 'density' => 1025, 'mu' => 1.08e-3, 'cp' => 3993, 'k' => 0.596],
        'air' => ['name' => 'Air', 'density' => 1.204, 'mu' => 1.813e-5, 'cp' => 1005, 'k' => 0.0257],
        'ethanol' => ['name' => 'Ethanol', 'density' => 789, 'mu' => 1.2e-3, 'cp' => 2440, 'k' => 0.171],
        'glycerol' => ['name' => 'Glycerol', 'density' => 1261, 'mu' => 1.412, 'cp' => 2430, 'k' => 0.285],
        'engine_oil' => ['name' => 'Engine oil (SAE 30)', 'density' => 880, 'mu' => 0.29, 'cp' => 1880, 'k' => 0.145],
        'olive_oil' => ['name' => 'Olive oil', 'density' => 911, 'mu' => 0.084, 'cp' => 1970, 'k' => 0.17],
        'petrol' => ['name' => 'Petrol (gasoline)', 'density' => 745, 'mu' => 6.0e-4, 'cp' => 2220, 'k' => 0.15],
        'diesel' => ['name' => 'Diesel', 'density' => 832, 'mu' => 3.3e-3, 'cp' => 2050, 'k' => 0.13],
        'mercury' => ['name' => 'Mercury', 'density' => 13534, 'mu' => 1.526e-3, 'cp' => 139, 'k' => 8.5],
        'milk' => ['name' => 'Milk', 'density' => 1030, 'mu' => 2.0e-3, 'cp' => 3930, 'k' => 0.53],
        'honey' => ['name' => 'Honey', 'density' => 1420, 'mu' => 10, 'cp' => 2500, 'k' => 0.5],
    ],

    /*
    | Gases: molar mass (g/mol), ratio of specific heats γ near room temperature,
    | kinetic diameter (pm) for mean free path, and critical temperature (K),
    | critical pressure (MPa) and acentric factor ω for the Peng–Robinson equation.
    | Sources: NIST Chemistry WebBook; Poling, Prausnitz & O'Connell, The Properties
    | of Gases and Liquids, 5th ed., Appendix A; Breck (kinetic diameters).
    */
    'gases' => [
        'air' => ['name' => 'Air', 'molar' => 28.9647, 'gamma' => 1.4, 'd' => 365, 'tc' => 132.5, 'pc' => 3.786, 'omega' => 0.035],
        'nitrogen' => ['name' => 'Nitrogen', 'molar' => 28.0134, 'gamma' => 1.4, 'd' => 364, 'tc' => 126.2, 'pc' => 3.398, 'omega' => 0.0372],
        'oxygen' => ['name' => 'Oxygen', 'molar' => 31.998, 'gamma' => 1.395, 'd' => 346, 'tc' => 154.58, 'pc' => 5.043, 'omega' => 0.022],
        'co2' => ['name' => 'Carbon dioxide', 'molar' => 44.01, 'gamma' => 1.289, 'd' => 330, 'tc' => 304.13, 'pc' => 7.3773, 'omega' => 0.224],
        'methane' => ['name' => 'Methane', 'molar' => 16.043, 'gamma' => 1.304, 'd' => 380, 'tc' => 190.56, 'pc' => 4.599, 'omega' => 0.011],
        'propane' => ['name' => 'Propane', 'molar' => 44.097, 'gamma' => 1.13, 'd' => 430, 'tc' => 369.83, 'pc' => 4.248, 'omega' => 0.152],
        'hydrogen' => ['name' => 'Hydrogen', 'molar' => 2.016, 'gamma' => 1.405, 'd' => 289, 'tc' => 33.19, 'pc' => 1.313, 'omega' => -0.216],
        'helium' => ['name' => 'Helium', 'molar' => 4.0026, 'gamma' => 1.667, 'd' => 260, 'tc' => 5.195, 'pc' => 0.2275, 'omega' => -0.390],
        'argon' => ['name' => 'Argon', 'molar' => 39.948, 'gamma' => 1.667, 'd' => 340, 'tc' => 150.69, 'pc' => 4.863, 'omega' => -0.002],
        'steam' => ['name' => 'Water vapour', 'molar' => 18.015, 'gamma' => 1.33, 'd' => 265, 'tc' => 647.1, 'pc' => 22.064, 'omega' => 0.345],
        'ammonia' => ['name' => 'Ammonia', 'molar' => 17.031, 'gamma' => 1.31, 'd' => 260, 'tc' => 405.4, 'pc' => 11.333, 'omega' => 0.253],
    ],

    /*
    | Latent heats (kJ/kg) and transition temperatures (°C) at 1 atm. Sources: CRC
    | Handbook; NIST WebBook. Water's heat of vaporisation is at 100 °C.
    */
    'latent' => [
        'water' => ['name' => 'Water', 'fusion' => 333.55, 'vaporisation' => 2256.4, 'melt' => 0, 'boil' => 100],
        'ethanol' => ['name' => 'Ethanol', 'fusion' => 108, 'vaporisation' => 841, 'melt' => -114.1, 'boil' => 78.4],
        'ammonia' => ['name' => 'Ammonia', 'fusion' => 332.2, 'vaporisation' => 1369, 'melt' => -77.7, 'boil' => -33.3],
        'nitrogen' => ['name' => 'Nitrogen', 'fusion' => 25.7, 'vaporisation' => 199.2, 'melt' => -210, 'boil' => -195.8],
        'mercury' => ['name' => 'Mercury', 'fusion' => 11.4, 'vaporisation' => 294.7, 'melt' => -38.8, 'boil' => 356.7],
        'lead' => ['name' => 'Lead', 'fusion' => 23.0, 'vaporisation' => 866, 'melt' => 327.5, 'boil' => 1749],
        'aluminium' => ['name' => 'Aluminium', 'fusion' => 397, 'vaporisation' => 10500, 'melt' => 660.3, 'boil' => 2470],
        'copper' => ['name' => 'Copper', 'fusion' => 208.7, 'vaporisation' => 4730, 'melt' => 1084.6, 'boil' => 2562],
        'iron' => ['name' => 'Iron', 'fusion' => 247.3, 'vaporisation' => 6088, 'melt' => 1538, 'boil' => 2862],
        'paraffin' => ['name' => 'Paraffin wax', 'fusion' => 200, 'vaporisation' => null, 'melt' => 58, 'boil' => null],
    ],

    /*
    | Thermal properties near 20 °C: conductivity k (W/(m·K)), density (kg/m³),
    | specific heat c_p (J/(kg·K)) and linear expansion α (10⁻⁶/K). Sources: Incropera
    | Appendix A; CIBSE Guide A; ASHRAE Fundamentals ch. 26 (building materials).
    | Building products vary: use declared values for design.
    */
    'thermal' => [
        'copper' => ['name' => 'Copper', 'k' => 401, 'density' => 8933, 'cp' => 385, 'alpha' => 16.5],
        'aluminium' => ['name' => 'Aluminium', 'k' => 237, 'density' => 2702, 'cp' => 903, 'alpha' => 23.1],
        'brass' => ['name' => 'Brass', 'k' => 110, 'density' => 8530, 'cp' => 380, 'alpha' => 19],
        'steel' => ['name' => 'Carbon steel', 'k' => 50, 'density' => 7850, 'cp' => 490, 'alpha' => 12],
        'stainless' => ['name' => 'Stainless steel 304', 'k' => 16.2, 'density' => 8000, 'cp' => 500, 'alpha' => 17.3],
        'glass' => ['name' => 'Glass', 'k' => 1.0, 'density' => 2500, 'cp' => 840, 'alpha' => 9],
        'granite' => ['name' => 'Granite', 'k' => 2.8, 'density' => 2700, 'cp' => 790, 'alpha' => 8],
        'concrete' => ['name' => 'Concrete', 'k' => 1.4, 'density' => 2300, 'cp' => 880, 'alpha' => 12],
        'brick' => ['name' => 'Brick', 'k' => 0.72, 'density' => 1920, 'cp' => 835, 'alpha' => 5.5],
        'gypsum' => ['name' => 'Gypsum plasterboard', 'k' => 0.17, 'density' => 800, 'cp' => 1090, 'alpha' => 16],
        'pine' => ['name' => 'Softwood (pine)', 'k' => 0.12, 'density' => 500, 'cp' => 1700, 'alpha' => 5],
        'plywood' => ['name' => 'Plywood', 'k' => 0.13, 'density' => 545, 'cp' => 1215, 'alpha' => 6],
        'pvc' => ['name' => 'PVC', 'k' => 0.19, 'density' => 1400, 'cp' => 900, 'alpha' => 52],
        'mineral_wool' => ['name' => 'Mineral wool', 'k' => 0.038, 'density' => 30, 'cp' => 840, 'alpha' => null],
        'eps' => ['name' => 'Expanded polystyrene (EPS)', 'k' => 0.035, 'density' => 20, 'cp' => 1300, 'alpha' => null],
        'pir' => ['name' => 'Polyisocyanurate (PIR) board', 'k' => 0.023, 'density' => 32, 'cp' => 1400, 'alpha' => null],
        'ice' => ['name' => 'Ice (0 °C)', 'k' => 2.22, 'density' => 917, 'cp' => 2050, 'alpha' => 51],
        'water' => ['name' => 'Water', 'k' => 0.598, 'density' => 998, 'cp' => 4182, 'alpha' => null],
        'air' => ['name' => 'Air (still)', 'k' => 0.0257, 'density' => 1.204, 'cp' => 1005, 'alpha' => null],
    ],

    /*
    | Manning roughness n (s/m^⅓), normal values from Chow, Open-Channel Hydraulics
    | (1959), Table 5-6.
    */
    'manning' => [
        'pvc' => ['name' => 'PVC or smooth plastic', 'n' => 0.009],
        'concrete_finished' => ['name' => 'Concrete, trowel finished', 'n' => 0.013],
        'concrete_unfinished' => ['name' => 'Concrete, unfinished', 'n' => 0.017],
        'cast_iron' => ['name' => 'Cast iron', 'n' => 0.013],
        'corrugated' => ['name' => 'Corrugated metal', 'n' => 0.024],
        'earth_clean' => ['name' => 'Earth channel, clean', 'n' => 0.022],
        'gravel' => ['name' => 'Gravel bed', 'n' => 0.025],
        'earth_weedy' => ['name' => 'Earth channel, grass and weeds', 'n' => 0.030],
        'natural' => ['name' => 'Natural stream, clean and straight', 'n' => 0.030],
        'natural_stony' => ['name' => 'Natural stream, stones and weeds', 'n' => 0.035],
    ],

    /*
    | Absolute pipe roughness ε (mm), new pipe, from Moody (1944) and White, Fluid
    | Mechanics, Table 6.1.
    */
    'roughness' => [
        'drawn' => ['name' => 'Drawn tubing (copper, brass)', 'e' => 0.0015],
        'pvc' => ['name' => 'PVC or plastic', 'e' => 0.0015],
        'steel' => ['name' => 'Commercial steel', 'e' => 0.045],
        'stainless' => ['name' => 'Stainless steel', 'e' => 0.002],
        'galvanized' => ['name' => 'Galvanized iron', 'e' => 0.15],
        'cast_iron' => ['name' => 'Cast iron', 'e' => 0.26],
        'ductile' => ['name' => 'Ductile iron, cement lined', 'e' => 0.03],
        'concrete' => ['name' => 'Concrete', 'e' => 1.0],
        'riveted' => ['name' => 'Riveted steel', 'e' => 3.0],
    ],

    /*
    | Free-electron metals: conduction electron density n (10²⁸ m⁻³), from Ashcroft &
    | Mermin, Solid State Physics, Table 1.1.
    */
    'metals' => [
        'li' => ['name' => 'Lithium', 'n' => 4.70],
        'na' => ['name' => 'Sodium', 'n' => 2.65],
        'k' => ['name' => 'Potassium', 'n' => 1.40],
        'cu' => ['name' => 'Copper', 'n' => 8.47],
        'ag' => ['name' => 'Silver', 'n' => 5.86],
        'au' => ['name' => 'Gold', 'n' => 5.90],
        'mg' => ['name' => 'Magnesium', 'n' => 8.61],
        'zn' => ['name' => 'Zinc', 'n' => 13.2],
        'al' => ['name' => 'Aluminium', 'n' => 18.1],
        'fe' => ['name' => 'Iron', 'n' => 17.0],
    ],

    /*
    | Work functions (eV) of clean polycrystalline surfaces, CRC Handbook of Chemistry
    | and Physics, "Electron Work Function of the Elements". Surfaces vary by ±0.1–0.3 eV.
    */
    'work_functions' => [
        'cs' => ['name' => 'Caesium', 'phi' => 2.14],
        'k' => ['name' => 'Potassium', 'phi' => 2.30],
        'na' => ['name' => 'Sodium', 'phi' => 2.36],
        'ca' => ['name' => 'Calcium', 'phi' => 2.87],
        'li' => ['name' => 'Lithium', 'phi' => 2.93],
        'mg' => ['name' => 'Magnesium', 'phi' => 3.66],
        'ag' => ['name' => 'Silver', 'phi' => 4.26],
        'al' => ['name' => 'Aluminium', 'phi' => 4.28],
        'zn' => ['name' => 'Zinc', 'phi' => 4.33],
        'fe' => ['name' => 'Iron', 'phi' => 4.5],
        'w' => ['name' => 'Tungsten', 'phi' => 4.55],
        'cu' => ['name' => 'Copper', 'phi' => 4.65],
        'au' => ['name' => 'Gold', 'phi' => 5.1],
        'pt' => ['name' => 'Platinum', 'phi' => 5.65],
    ],

    /*
    | Atomic masses (u) of common nuclides, Atomic Mass Evaluation AME2020 (Wang et al.,
    | Chinese Physics C 45, 030003, 2021). Neutral-atom masses, so the hydrogen-atom mass is
    | used for the protons and electrons together.
    */
    'nuclides' => [
        'h2' => ['name' => 'Deuterium (²H)', 'Z' => 1, 'A' => 2, 'mass' => 2.01410177812],
        'h3' => ['name' => 'Tritium (³H)', 'Z' => 1, 'A' => 3, 'mass' => 3.01604928132],
        'he3' => ['name' => 'Helium-3', 'Z' => 2, 'A' => 3, 'mass' => 3.01602932197],
        'he4' => ['name' => 'Helium-4', 'Z' => 2, 'A' => 4, 'mass' => 4.00260325413],
        'li6' => ['name' => 'Lithium-6', 'Z' => 3, 'A' => 6, 'mass' => 6.01512288742],
        'li7' => ['name' => 'Lithium-7', 'Z' => 3, 'A' => 7, 'mass' => 7.01600343426],
        'be9' => ['name' => 'Beryllium-9', 'Z' => 4, 'A' => 9, 'mass' => 9.01218306],
        'c12' => ['name' => 'Carbon-12', 'Z' => 6, 'A' => 12, 'mass' => 12],
        'c14' => ['name' => 'Carbon-14', 'Z' => 6, 'A' => 14, 'mass' => 14.0032419884],
        'n14' => ['name' => 'Nitrogen-14', 'Z' => 7, 'A' => 14, 'mass' => 14.00307400425],
        'o16' => ['name' => 'Oxygen-16', 'Z' => 8, 'A' => 16, 'mass' => 15.99491461926],
        'ne20' => ['name' => 'Neon-20', 'Z' => 10, 'A' => 20, 'mass' => 19.9924401753],
        'na23' => ['name' => 'Sodium-23', 'Z' => 11, 'A' => 23, 'mass' => 22.989769282],
        'si28' => ['name' => 'Silicon-28', 'Z' => 14, 'A' => 28, 'mass' => 27.97692653442],
        'ca40' => ['name' => 'Calcium-40', 'Z' => 20, 'A' => 40, 'mass' => 39.962590851],
        'fe56' => ['name' => 'Iron-56', 'Z' => 26, 'A' => 56, 'mass' => 55.93493554],
        'ni62' => ['name' => 'Nickel-62', 'Z' => 28, 'A' => 62, 'mass' => 61.92834475],
        'pb208' => ['name' => 'Lead-208', 'Z' => 82, 'A' => 208, 'mass' => 207.9766525],
        'u235' => ['name' => 'Uranium-235', 'Z' => 92, 'A' => 235, 'mass' => 235.0439281],
        'u238' => ['name' => 'Uranium-238', 'Z' => 92, 'A' => 238, 'mass' => 238.0507884],
    ],

];
