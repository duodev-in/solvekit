<x-tool-page-layout
    title="Energy Conversion Calculator - SolveKit"
    description="Professional energy unit converter between joules, calories, BTU, kWh, and other energy measurements. Convert thermal, electrical, and mechanical energy units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Energy Conversion Calculator</h1>
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
                                                                                    Enter Energy Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter energy (e.g., 1000)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter energy value for conversion</p>
                                                                            </div>

                                                                            <!-- From Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="fromUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    From Unit (Source)
                                                                                </label>
                                                                                <select 
                                                                                    id="fromUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="SI Energy Units">
                                                                                        <option value="joule" selected>Joule (J) - SI energy unit</option>
                                                                                        <option value="kilojoule">Kilojoule (kJ)</option>
                                                                                        <option value="megajoule">Megajoule (MJ)</option>
                                                                                        <option value="gigajoule">Gigajoule (GJ)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Electrical Energy">
                                                                                        <option value="kilowatt_hour">Kilowatt Hour (kWh)</option>
                                                                                        <option value="watt_hour">Watt Hour (Wh)</option>
                                                                                        <option value="megawatt_hour">Megawatt Hour (MWh)</option>
                                                                                        <option value="electron_volt">Electron Volt (eV)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Thermal Energy">
                                                                                        <option value="calorie">Calorie (cal)</option>
                                                                                        <option value="kilocalorie">Kilocalorie (kcal)</option>
                                                                                        <option value="btu">British Thermal Unit (BTU)</option>
                                                                                        <option value="therm">Therm</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Mechanical Energy">
                                                                                        <option value="foot_pound">Foot-Pound (ft⋅lb)</option>
                                                                                        <option value="newton_meter">Newton-Meter (N⋅m)</option>
                                                                                        <option value="erg">Erg</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Alternative Units">
                                                                                        <option value="tnt_equivalent">TNT Equivalent (kg)</option>
                                                                                        <option value="gasoline_equivalent">Gasoline Equivalent (L)</option>
                                                                                        <option value="food_calorie">Food Calorie (Cal)</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            <!-- To Unit -->
                                                                            <div class="space-y-2">
                                                                                <label for="toUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    To Unit (Target)
                                                                                </label>
                                                                                <select 
                                                                                    id="toUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="SI Energy Units">
                                                                                        <option value="joule">Joule (J) - SI energy unit</option>
                                                                                        <option value="kilojoule" selected>Kilojoule (kJ)</option>
                                                                                        <option value="megajoule">Megajoule (MJ)</option>
                                                                                        <option value="gigajoule">Gigajoule (GJ)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Electrical Energy">
                                                                                        <option value="kilowatt_hour">Kilowatt Hour (kWh)</option>
                                                                                        <option value="watt_hour">Watt Hour (Wh)</option>
                                                                                        <option value="megawatt_hour">Megawatt Hour (MWh)</option>
                                                                                        <option value="electron_volt">Electron Volt (eV)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Thermal Energy">
                                                                                        <option value="calorie">Calorie (cal)</option>
                                                                                        <option value="kilocalorie">Kilocalorie (kcal)</option>
                                                                                        <option value="btu">British Thermal Unit (BTU)</option>
                                                                                        <option value="therm">Therm</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Mechanical Energy">
                                                                                        <option value="foot_pound">Foot-Pound (ft⋅lb)</option>
                                                                                        <option value="newton_meter">Newton-Meter (N⋅m)</option>
                                                                                        <option value="erg">Erg</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Alternative Units">
                                                                                        <option value="tnt_equivalent">TNT Equivalent (kg)</option>
                                                                                        <option value="gasoline_equivalent">Gasoline Equivalent (L)</option>
                                                                                        <option value="food_calorie">Food Calorie (Cal)</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>
                                                                            </div>

                                                                            <!-- Energy Type -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Energy Type
                                                                                </label>
                                                                                <select 
                                                                                    id="energyType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="">General energy</option>
                                                                                    <option value="kinetic">Kinetic Energy</option>
                                                                                    <option value="potential">Potential Energy</option>
                                                                                    <option value="thermal">Thermal Energy</option>
                                                                                    <option value="electrical">Electrical Energy</option>
                                                                                    <option value="chemical">Chemical Energy</option>
                                                                                    <option value="nuclear">Nuclear Energy</option>
                                                                                </select>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Energy Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-red-50 to-pink-50 rounded-xl border-l-4 border-red-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Energy</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-red-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-red-600 hover:text-red-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Energy Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- SI Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">SI Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Joules</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="joulesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI energy unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Kilojoules</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="kilojoulesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1000 joules</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Megajoules</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="megajoulesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Million joules</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Electrical Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Electrical Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">kWh</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="kwhDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Kilowatt hours</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Wh</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="whDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Watt hours</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">eV</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="evDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Electron volts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Thermal Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Thermal Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Calories</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="caloriesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Thermal calories</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">BTU</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="btuDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">British thermal units</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Food Cal</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="foodCalDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Dietary calories</div>
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
                <!-- Quick Energy Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Energy Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="energy-example px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-value="1000" data-from="joule" data-to="kilojoule">1000 J</button>
                                                            <button type="button" class="energy-example px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-value="1" data-from="kilowatt_hour" data-to="joule">1 kWh</button>
                                                            <button type="button" class="energy-example px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-value="1000" data-from="btu" data-to="joule">1000 BTU</button>
                                                            <button type="button" class="energy-example px-3 py-2 text-sm bg-gray-100 hover:bg-red-100 text-gray-700 hover:text-red-700 rounded-lg transition-colors" data-value="100" data-from="calorie" data-to="joule">100 cal</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Energy Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Energy Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 J</strong> = 0.239 cal</div>
                                                        <div><strong>1 cal</strong> = 4.184 J</div>
                                                        <div><strong>1 kWh</strong> = 3.6 MJ</div>
                                                        <div><strong>1 BTU</strong> = 1055 J</div>
                                                        <div><strong>1 erg</strong> = 10⁻⁷ J</div>
                                                        <div><strong>1 eV</strong> = 1.602×10⁻¹⁹ J</div>
                                                        <div><strong>1 therm</strong> = 105.5 MJ</div>
                                                        <div><strong>1 ft⋅lb</strong> = 1.356 J</div>
                                                        <div><strong>Food cal</strong> = 1000 cal</div>
                                                        <div><strong>TNT</strong> = 4.6 MJ/kg</div>
                                                        <div><strong>Gasoline</strong> = 34.2 MJ/L</div>
                                                        <div><strong>Coal</strong> = 24 MJ/kg</div>
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
                        const energyType = document.getElementById('energyType');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const joulesDisplay = document.getElementById('joulesDisplay');
                        const kilojoulesDisplay = document.getElementById('kilojoulesDisplay');
                        const megajoulesDisplay = document.getElementById('megajoulesDisplay');
                        const kwhDisplay = document.getElementById('kwhDisplay');
                        const whDisplay = document.getElementById('whDisplay');
                        const evDisplay = document.getElementById('evDisplay');
                        const caloriesDisplay = document.getElementById('caloriesDisplay');
                        const btuDisplay = document.getElementById('btuDisplay');
                        const foodCalDisplay = document.getElementById('foodCalDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Energy conversion multipliers (to joules as base)
                        const energyMultipliers = {
                            joule: 1,
                            kilojoule: 1000,
                            megajoule: 1000000,
                            gigajoule: 1000000000,
                            kilowatt_hour: 3600000,
                            watt_hour: 3600,
                            megawatt_hour: 3600000000,
                            electron_volt: 1.602176634e-19,
                            calorie: 4.184,
                            kilocalorie: 4184,
                            btu: 1055.06,
                            therm: 105505600,
                            foot_pound: 1.355818,
                            newton_meter: 1,
                            erg: 1e-7,
                            tnt_equivalent: 4600000,
                            gasoline_equivalent: 34200000,
                            food_calorie: 4184
                        };

                        const unitLabels = {
                            joule: 'J',
                            kilojoule: 'kJ',
                            megajoule: 'MJ',
                            gigajoule: 'GJ',
                            kilowatt_hour: 'kWh',
                            watt_hour: 'Wh',
                            megawatt_hour: 'MWh',
                            electron_volt: 'eV',
                            calorie: 'cal',
                            kilocalorie: 'kcal',
                            btu: 'BTU',
                            therm: 'therm',
                            foot_pound: 'ft⋅lb',
                            newton_meter: 'N⋅m',
                            erg: 'erg',
                            tnt_equivalent: 'kg TNT',
                            gasoline_equivalent: 'L gas',
                            food_calorie: 'Cal'
                        };

                        const unitNames = {
                            joule: 'Joules',
                            kilojoule: 'Kilojoules',
                            megajoule: 'Megajoules',
                            gigajoule: 'Gigajoules',
                            kilowatt_hour: 'Kilowatt Hours',
                            watt_hour: 'Watt Hours',
                            megawatt_hour: 'Megawatt Hours',
                            electron_volt: 'Electron Volts',
                            calorie: 'Calories',
                            kilocalorie: 'Kilocalories',
                            btu: 'British Thermal Units',
                            therm: 'Therms',
                            foot_pound: 'Foot-Pounds',
                            newton_meter: 'Newton-Meters',
                            erg: 'Ergs',
                            tnt_equivalent: 'TNT Equivalent',
                            gasoline_equivalent: 'Gasoline Equivalent',
                            food_calorie: 'Food Calories'
                        };

                        function formatNumber(num, decimals = 3) {
                            const absolute = Math.abs(num);
                            if (absolute >= 1e15 || (absolute < 1e-6 && num !== 0)) {
                                return num.toExponential(3).replace(/\.?0+e/, 'e');
                            } else if (absolute >= 1e6) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            } else if (absolute < 1 && num !== 0) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            } else {
                                return num.toLocaleString(undefined, { maximumFractionDigits: decimals, minimumFractionDigits: 0 });
                            }
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                // Convert input to joules first
                                const inputInJoules = inputVal * energyMultipliers[from];
                                
                                // Convert joules to target unit
                                const result = inputInJoules / energyMultipliers[to];
                                
                                // Update primary output
                                output.textContent = formatNumber(result) + ' ' + unitLabels[to];
                                resultTitle.textContent = `${unitNames[to]} (${unitLabels[to]})`;
                                resultDescription.textContent = `${inputVal} ${unitLabels[from]} = ${formatNumber(result)} ${unitLabels[to]}`;

                                // Convert to all common units and display
                                const joules = inputInJoules;
                                joulesDisplay.textContent = formatNumber(joules);
                                kilojoulesDisplay.textContent = formatNumber(joules / energyMultipliers.kilojoule);
                                megajoulesDisplay.textContent = formatNumber(joules / energyMultipliers.megajoule);
                                kwhDisplay.textContent = formatNumber(joules / energyMultipliers.kilowatt_hour);
                                whDisplay.textContent = formatNumber(joules / energyMultipliers.watt_hour);
                                evDisplay.textContent = formatNumber(joules / energyMultipliers.electron_volt);
                                caloriesDisplay.textContent = formatNumber(joules / energyMultipliers.calorie);
                                btuDisplay.textContent = formatNumber(joules / energyMultipliers.btu);
                                foodCalDisplay.textContent = formatNumber(joules / energyMultipliers.food_calorie);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Energy';
                            resultDescription.textContent = 'Converted result';
                            joulesDisplay.textContent = '--';
                            kilojoulesDisplay.textContent = '--';
                            megajoulesDisplay.textContent = '--';
                            kwhDisplay.textContent = '--';
                            whDisplay.textContent = '--';
                            evDisplay.textContent = '--';
                            caloriesDisplay.textContent = '--';
                            btuDisplay.textContent = '--';
                            foodCalDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'joule';
                            toUnit.value = 'kilojoule';
                            energyType.value = '';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
                        toUnit.addEventListener('change', convert);
                        energyType.addEventListener('change', convert);

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
                        const energyExamples = document.querySelectorAll('.energy-example');
                        energyExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                energyExamples.forEach(btn => btn.classList.remove('bg-red-100', 'text-red-700'));
                                energyExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-red-100', 'text-red-700');
                            });
                        });

                        // Initialize
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
