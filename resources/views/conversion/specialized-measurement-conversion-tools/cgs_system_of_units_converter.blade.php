<x-tool-page-layout
    title="CGS System of Units Converter - ConvertPro"
    description="Professional CGS system converter for scientific calculations. Convert between Centimeter-Gram-Second units and SI, Imperial systems with precision for physics and chemistry applications."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">CGS System of Units Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter value (e.g., 1000)"
                                                                                        step="any"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Value</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter numerical value for conversion</p>
                                                                            </div>

                                                                            <!-- From Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    From Unit (Source)
                                                                                </label>
                                                                                <select 
                                                                                    id="fromUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="CGS Base Units">
                                                                                        <option value="cm" selected>Centimeter (cm) - Length</option>
                                                                                        <option value="gram">Gram (g) - Mass</option>
                                                                                        <option value="second">Second (s) - Time</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="CGS Derived Units - Mechanical">
                                                                                        <option value="dyne">Dyne (dyn) - Force</option>
                                                                                        <option value="cm_per_s">Centimeter per Second (cm/s) - Velocity</option>
                                                                                        <option value="cm_per_s2">Centimeter per Second² (cm/s²) - Acceleration</option>
                                                                                        <option value="erg">Erg (erg) - Energy</option>
                                                                                        <option value="erg_per_s">Erg per Second (erg/s) - Power</option>
                                                                                        <option value="barye">Barye (Ba) - Pressure</option>
                                                                                        <option value="poise">Poise (P) - Dynamic Viscosity</option>
                                                                                        <option value="stokes">Stokes (St) - Kinematic Viscosity</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="CGS Electromagnetic Units">
                                                                                        <option value="statcoulomb">Statcoulomb (statC) - Charge</option>
                                                                                        <option value="statvolt">Statvolt (statV) - Voltage</option>
                                                                                        <option value="statampere">Statampere (statA) - Current</option>
                                                                                        <option value="gauss">Gauss (G) - Magnetic Field</option>
                                                                                        <option value="oersted">Oersted (Oe) - Magnetic Intensity</option>
                                                                                        <option value="maxwell">Maxwell (Mx) - Magnetic Flux</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="SI Units">
                                                                                        <option value="meter">Meter (m) - Length</option>
                                                                                        <option value="kilogram">Kilogram (kg) - Mass</option>
                                                                                        <option value="newton">Newton (N) - Force</option>
                                                                                        <option value="joule">Joule (J) - Energy</option>
                                                                                        <option value="watt">Watt (W) - Power</option>
                                                                                        <option value="pascal">Pascal (Pa) - Pressure</option>
                                                                                        <option value="tesla">Tesla (T) - Magnetic Field</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Imperial Units">
                                                                                        <option value="inch">Inch (in) - Length</option>
                                                                                        <option value="foot">Foot (ft) - Length</option>
                                                                                        <option value="pound_mass">Pound (lb) - Mass</option>
                                                                                        <option value="pound_force">Pound-force (lbf) - Force</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            <!-- To Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    To Unit (Target)
                                                                                </label>
                                                                                <select 
                                                                                    id="toUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="CGS Base Units">
                                                                                        <option value="cm">Centimeter (cm) - Length</option>
                                                                                        <option value="gram">Gram (g) - Mass</option>
                                                                                        <option value="second">Second (s) - Time</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="CGS Derived Units - Mechanical">
                                                                                        <option value="dyne">Dyne (dyn) - Force</option>
                                                                                        <option value="cm_per_s">Centimeter per Second (cm/s) - Velocity</option>
                                                                                        <option value="cm_per_s2">Centimeter per Second² (cm/s²) - Acceleration</option>
                                                                                        <option value="erg">Erg (erg) - Energy</option>
                                                                                        <option value="erg_per_s">Erg per Second (erg/s) - Power</option>
                                                                                        <option value="barye">Barye (Ba) - Pressure</option>
                                                                                        <option value="poise">Poise (P) - Dynamic Viscosity</option>
                                                                                        <option value="stokes">Stokes (St) - Kinematic Viscosity</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="CGS Electromagnetic Units">
                                                                                        <option value="statcoulomb">Statcoulomb (statC) - Charge</option>
                                                                                        <option value="statvolt">Statvolt (statV) - Voltage</option>
                                                                                        <option value="statampere">Statampere (statA) - Current</option>
                                                                                        <option value="gauss">Gauss (G) - Magnetic Field</option>
                                                                                        <option value="oersted">Oersted (Oe) - Magnetic Intensity</option>
                                                                                        <option value="maxwell">Maxwell (Mx) - Magnetic Flux</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="SI Units">
                                                                                        <option value="meter" selected>Meter (m) - Length</option>
                                                                                        <option value="kilogram">Kilogram (kg) - Mass</option>
                                                                                        <option value="newton">Newton (N) - Force</option>
                                                                                        <option value="joule">Joule (J) - Energy</option>
                                                                                        <option value="watt">Watt (W) - Power</option>
                                                                                        <option value="pascal">Pascal (Pa) - Pressure</option>
                                                                                        <option value="tesla">Tesla (T) - Magnetic Field</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Imperial Units">
                                                                                        <option value="inch">Inch (in) - Length</option>
                                                                                        <option value="foot">Foot (ft) - Length</option>
                                                                                        <option value="pound_mass">Pound (lb) - Mass</option>
                                                                                        <option value="pound_force">Pound-force (lbf) - Force</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            </div>

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">CGS Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl border-l-4 border-rose-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Value</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-rose-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-rose-600 hover:text-rose-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Unit System Comparison -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- CGS Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">CGS Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Length</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="cgsLengthDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">centimeters</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Mass</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="cgsMassDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">grams</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Force</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="cgsForceDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">dynes</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Energy</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="cgsEnergyDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">ergs</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- SI Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">SI Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Length</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="siLengthDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">meters</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Mass</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="siMassDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">kilograms</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Force</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="siForceDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">newtons</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-violet-50 to-purple-50 rounded-lg border-l-4 border-violet-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Energy</h5>
                                                                                            <div class="text-lg font-bold text-violet-600 font-mono" id="siEnergyDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">joules</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Imperial Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Imperial Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Length</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="imperialLengthDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">feet/inches</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Mass</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="imperialMassDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">pounds</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-sky-50 to-blue-50 rounded-lg border-l-4 border-sky-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Force</h5>
                                                                                            <div class="text-lg font-bold text-sky-600 font-mono" id="imperialForceDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">pound-force</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-green-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Energy</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="imperialEnergyDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">foot-pounds</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>



                                                                    </div>
                                    </div>
                                </div>
                            </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick CGS Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick CGS Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="cgs-example px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-gray-700 hover:text-rose-700 rounded-lg transition-colors" data-value="100" data-from="cm" data-to="meter">100 cm</button>
                                                            <button type="button" class="cgs-example px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-gray-700 hover:text-rose-700 rounded-lg transition-colors" data-value="1000" data-from="gram" data-to="kilogram">1000 g</button>
                                                            <button type="button" class="cgs-example px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-gray-700 hover:text-rose-700 rounded-lg transition-colors" data-value="100000" data-from="dyne" data-to="newton">100k dyn</button>
                                                            <button type="button" class="cgs-example px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-gray-700 hover:text-rose-700 rounded-lg transition-colors" data-value="10000" data-from="gauss" data-to="tesla">10k G</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- CGS Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">CGS System Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 cm</strong> = 0.01 m</div>
                                                        <div><strong>1 g</strong> = 0.001 kg</div>
                                                        <div><strong>1 dyne</strong> = 10⁻⁵ N</div>
                                                        <div><strong>1 erg</strong> = 10⁻⁷ J</div>
                                                        <div><strong>1 barye</strong> = 0.1 Pa</div>
                                                        <div><strong>1 poise</strong> = 0.1 Pa⋅s</div>
                                                        <div><strong>1 gauss</strong> = 10⁻⁴ T</div>
                                                        <div><strong>1 oersted</strong> = 79.58 A/m</div>
                                                        <div><strong>Base units:</strong> cm, g, s</div>
                                                        <div><strong>Derived:</strong> dyne, erg, barye</div>
                                                        <div><strong>EM units:</strong> esu, emu systems</div>
                                                        <div><strong>Applications:</strong> Physics, Chemistry</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const fromUnit = document.getElementById('fromUnit');
                        const toUnit = document.getElementById('toUnit');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const cgsLengthDisplay = document.getElementById('cgsLengthDisplay');
                        const cgsMassDisplay = document.getElementById('cgsMassDisplay');
                        const cgsForceDisplay = document.getElementById('cgsForceDisplay');
                        const cgsEnergyDisplay = document.getElementById('cgsEnergyDisplay');
                        const siLengthDisplay = document.getElementById('siLengthDisplay');
                        const siMassDisplay = document.getElementById('siMassDisplay');
                        const siForceDisplay = document.getElementById('siForceDisplay');
                        const siEnergyDisplay = document.getElementById('siEnergyDisplay');
                        const imperialLengthDisplay = document.getElementById('imperialLengthDisplay');
                        const imperialMassDisplay = document.getElementById('imperialMassDisplay');
                        const imperialForceDisplay = document.getElementById('imperialForceDisplay');
                        const imperialEnergyDisplay = document.getElementById('imperialEnergyDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // CGS conversion factors (to SI base units)
                        const cgsConversions = {
                            // CGS Base units
                            cm: { si: 0.01, type: 'length', name: 'centimeter' },
                            gram: { si: 0.001, type: 'mass', name: 'gram' },
                            second: { si: 1, type: 'time', name: 'second' },
                            
                            // CGS Derived units
                            dyne: { si: 1e-5, type: 'force', name: 'dyne' },
                            cm_per_s: { si: 0.01, type: 'velocity', name: 'cm/s' },
                            cm_per_s2: { si: 0.01, type: 'acceleration', name: 'cm/s²' },
                            erg: { si: 1e-7, type: 'energy', name: 'erg' },
                            erg_per_s: { si: 1e-7, type: 'power', name: 'erg/s' },
                            barye: { si: 0.1, type: 'pressure', name: 'barye' },
                            poise: { si: 0.1, type: 'viscosity', name: 'poise' },
                            stokes: { si: 1e-4, type: 'kinematic_viscosity', name: 'stokes' },
                            
                            // CGS Electromagnetic units (simplified)
                            statcoulomb: { si: 3.336e-10, type: 'charge', name: 'statcoulomb' },
                            statvolt: { si: 299.8, type: 'voltage', name: 'statvolt' },
                            statampere: { si: 3.336e-10, type: 'current', name: 'statampere' },
                            gauss: { si: 1e-4, type: 'magnetic_field', name: 'gauss' },
                            oersted: { si: 79.58, type: 'magnetic_intensity', name: 'oersted' },
                            maxwell: { si: 1e-8, type: 'magnetic_flux', name: 'maxwell' },
                            
                            // SI units
                            meter: { si: 1, type: 'length', name: 'meter' },
                            kilogram: { si: 1, type: 'mass', name: 'kilogram' },
                            newton: { si: 1, type: 'force', name: 'newton' },
                            joule: { si: 1, type: 'energy', name: 'joule' },
                            watt: { si: 1, type: 'power', name: 'watt' },
                            pascal: { si: 1, type: 'pressure', name: 'pascal' },
                            tesla: { si: 1, type: 'magnetic_field', name: 'tesla' },
                            
                            // Imperial units
                            inch: { si: 0.0254, type: 'length', name: 'inch' },
                            foot: { si: 0.3048, type: 'length', name: 'foot' },
                            pound_mass: { si: 0.453592, type: 'mass', name: 'pound' },
                            pound_force: { si: 4.448, type: 'force', name: 'pound-force' }
                        };

                        const unitLabels = {
                            cm: 'cm', gram: 'g', second: 's', dyne: 'dyn', cm_per_s: 'cm/s',
                            cm_per_s2: 'cm/s²', erg: 'erg', erg_per_s: 'erg/s', barye: 'Ba',
                            poise: 'P', stokes: 'St', statcoulomb: 'statC', statvolt: 'statV',
                            statampere: 'statA', gauss: 'G', oersted: 'Oe', maxwell: 'Mx',
                            meter: 'm', kilogram: 'kg', newton: 'N', joule: 'J', watt: 'W',
                            pascal: 'Pa', tesla: 'T', inch: 'in', foot: 'ft',
                            pound_mass: 'lb', pound_force: 'lbf'
                        };

                        function formatNumber(num) {
                            if (!Number.isFinite(num)) {
                                return '--';
                            }
                            if (num === 0) {
                                return '0';
                            }
                            const abs = Math.abs(num);
                            if (abs >= 1e12 || abs < 1e-6) {
                                return parseFloat(num.toPrecision(5)).toExponential();
                            }
                            if (abs >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                            }
                            return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                        }

                        function unitDisplayName(select) {
                            return select.options[select.selectedIndex].text.split(' - ')[0];
                        }

                        function canConvert(fromUnit, toUnit) {
                            const fromInfo = cgsConversions[fromUnit];
                            const toInfo = cgsConversions[toUnit];

                            return Boolean(fromInfo && toInfo && fromInfo.type === toInfo.type);
                        }

                        function syncTargetUnits() {
                            const fromType = cgsConversions[fromUnit.value]?.type;
                            let firstCompatible = null;

                            Array.from(toUnit.options).forEach(option => {
                                const isCompatible = cgsConversions[option.value]?.type === fromType;
                                option.disabled = !isCompatible;
                                option.hidden = !isCompatible;
                                if (isCompatible && option.value !== fromUnit.value && !firstCompatible) {
                                    firstCompatible = option.value;
                                }
                            });

                            if (!canConvert(fromUnit.value, toUnit.value)) {
                                toUnit.value = firstCompatible || fromUnit.value;
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal)) {
                                if (!canConvert(from, to)) {
                                    output.textContent = 'Incompatible unit types';
                                    resultTitle.textContent = 'Converted Value';
                                    resultDescription.textContent = 'Cannot convert between different physical quantities';
                                    return;
                                }

                                const fromInfo = cgsConversions[from];
                                const toInfo = cgsConversions[to];
                                
                                // Convert via SI units
                                const siValue = inputVal * fromInfo.si;
                                const result = siValue / toInfo.si;
                                
                                // Update primary output
                                output.textContent = formatNumber(result) + ' ' + unitLabels[to];
                                resultTitle.textContent = unitDisplayName(toUnit);
                                resultDescription.textContent = `${formatNumber(inputVal)} ${unitLabels[from]} = ${formatNumber(result)} ${unitLabels[to]}`;

                                // Update unit system displays (showing equivalent values)
                                updateUnitSystemDisplays(inputVal, from);

                            } else {
                                clearOutputs();
                            }
                        }

                        function updateUnitSystemDisplays(value, unit) {
                            const unitInfo = cgsConversions[unit];
                            const siValue = value * unitInfo.si;
                            
                            // CGS equivalents
                            cgsLengthDisplay.textContent = unitInfo.type === 'length' ? formatNumber(siValue / cgsConversions.cm.si) + ' cm' : 'N/A';
                            cgsMassDisplay.textContent = unitInfo.type === 'mass' ? formatNumber(siValue / cgsConversions.gram.si) + ' g' : 'N/A';
                            cgsForceDisplay.textContent = unitInfo.type === 'force' ? formatNumber(siValue / cgsConversions.dyne.si) + ' dyn' : 'N/A';
                            cgsEnergyDisplay.textContent = unitInfo.type === 'energy' ? formatNumber(siValue / cgsConversions.erg.si) + ' erg' : 'N/A';
                            
                            // SI equivalents
                            siLengthDisplay.textContent = unitInfo.type === 'length' ? formatNumber(siValue) + ' m' : 'N/A';
                            siMassDisplay.textContent = unitInfo.type === 'mass' ? formatNumber(siValue) + ' kg' : 'N/A';
                            siForceDisplay.textContent = unitInfo.type === 'force' ? formatNumber(siValue) + ' N' : 'N/A';
                            siEnergyDisplay.textContent = unitInfo.type === 'energy' ? formatNumber(siValue) + ' J' : 'N/A';
                            
                            // Imperial equivalents
                            imperialLengthDisplay.textContent = unitInfo.type === 'length' ? formatNumber(siValue / cgsConversions.foot.si) + ' ft' : 'N/A';
                            imperialMassDisplay.textContent = unitInfo.type === 'mass' ? formatNumber(siValue / cgsConversions.pound_mass.si) + ' lb' : 'N/A';
                            imperialForceDisplay.textContent = unitInfo.type === 'force' ? formatNumber(siValue / cgsConversions.pound_force.si) + ' lbf' : 'N/A';
                            imperialEnergyDisplay.textContent = unitInfo.type === 'energy' ? formatNumber(siValue / 1.356) + ' ft⋅lb' : 'N/A';
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Value';
                            resultDescription.textContent = 'Converted result';
                            cgsLengthDisplay.textContent = '--';
                            cgsMassDisplay.textContent = '--';
                            cgsForceDisplay.textContent = '--';
                            cgsEnergyDisplay.textContent = '--';
                            siLengthDisplay.textContent = '--';
                            siMassDisplay.textContent = '--';
                            siForceDisplay.textContent = '--';
                            siEnergyDisplay.textContent = '--';
                            imperialLengthDisplay.textContent = '--';
                            imperialMassDisplay.textContent = '--';
                            imperialForceDisplay.textContent = '--';
                            imperialEnergyDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'cm';
                            syncTargetUnits();
                            toUnit.value = 'meter';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', function() {
                            syncTargetUnits();
                            convert();
                        });
                        toUnit.addEventListener('change', convert);

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
                        copyResult.addEventListener('click', function() {
                            const text = output.textContent;
                            if (text !== '--') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        // Example buttons
                        const cgsExamples = document.querySelectorAll('.cgs-example');
                        cgsExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                syncTargetUnits();
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                cgsExamples.forEach(btn => btn.classList.remove('bg-rose-100', 'text-rose-700'));
                                cgsExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-rose-100', 'text-rose-700');
                            });
                        });

                        // Initialize
                        syncTargetUnits();
                        inputValue.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
