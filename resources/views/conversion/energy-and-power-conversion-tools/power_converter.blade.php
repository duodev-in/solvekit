<x-tool-page-layout
    title="Power Converter - ConvertPro"
    description="Professional power unit converter between watts, horsepower, BTU/h, and other power measurements. Convert mechanical, electrical, and thermal power units with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Power Converter</h1>
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
                                                                                    Enter Power Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter power (e.g., 1000)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter power value for conversion</p>
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
                                                                                    <optgroup label="SI Power Units">
                                                                                        <option value="watt" selected>Watt (W) - SI power unit</option>
                                                                                        <option value="kilowatt">Kilowatt (kW)</option>
                                                                                        <option value="megawatt">Megawatt (MW)</option>
                                                                                        <option value="gigawatt">Gigawatt (GW)</option>
                                                                                        <option value="milliwatt">Milliwatt (mW)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Mechanical Power">
                                                                                        <option value="horsepower_mechanical">Horsepower (hp) - Mechanical</option>
                                                                                        <option value="horsepower_metric">Metric Horsepower (PS)</option>
                                                                                        <option value="horsepower_electric">Electric Horsepower</option>
                                                                                        <option value="horsepower_boiler">Boiler Horsepower</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Thermal Power">
                                                                                        <option value="btu_hour">BTU/hour (BTU/h)</option>
                                                                                        <option value="btu_minute">BTU/minute</option>
                                                                                        <option value="btu_second">BTU/second</option>
                                                                                        <option value="calorie_second">Calorie/second</option>
                                                                                        <option value="kcal_hour">kcal/hour</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Alternative Units">
                                                                                        <option value="foot_pound_second">Foot-pound/second</option>
                                                                                        <option value="erg_second">Erg/second</option>
                                                                                        <option value="joule_second">Joule/second</option>
                                                                                        <option value="ton_refrigeration">Ton of Refrigeration</option>
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
                                                                                    <optgroup label="SI Power Units">
                                                                                        <option value="watt">Watt (W) - SI power unit</option>
                                                                                        <option value="kilowatt" selected>Kilowatt (kW)</option>
                                                                                        <option value="megawatt">Megawatt (MW)</option>
                                                                                        <option value="gigawatt">Gigawatt (GW)</option>
                                                                                        <option value="milliwatt">Milliwatt (mW)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Mechanical Power">
                                                                                        <option value="horsepower_mechanical">Horsepower (hp) - Mechanical</option>
                                                                                        <option value="horsepower_metric">Metric Horsepower (PS)</option>
                                                                                        <option value="horsepower_electric">Electric Horsepower</option>
                                                                                        <option value="horsepower_boiler">Boiler Horsepower</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Thermal Power">
                                                                                        <option value="btu_hour">BTU/hour (BTU/h)</option>
                                                                                        <option value="btu_minute">BTU/minute</option>
                                                                                        <option value="btu_second">BTU/second</option>
                                                                                        <option value="calorie_second">Calorie/second</option>
                                                                                        <option value="kcal_hour">kcal/hour</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Alternative Units">
                                                                                        <option value="foot_pound_second">Foot-pound/second</option>
                                                                                        <option value="erg_second">Erg/second</option>
                                                                                        <option value="joule_second">Joule/second</option>
                                                                                        <option value="ton_refrigeration">Ton of Refrigeration</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>
                                                                            </div>

                                                                            <!-- Power Type -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Power Type
                                                                                </label>
                                                                                <select 
                                                                                    id="powerType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="">General power</option>
                                                                                    <option value="electrical">Electrical Power</option>
                                                                                    <option value="mechanical">Mechanical Power</option>
                                                                                    <option value="thermal">Thermal Power</option>
                                                                                    <option value="hydraulic">Hydraulic Power</option>
                                                                                    <option value="pneumatic">Pneumatic Power</option>
                                                                                    <option value="solar">Solar Power</option>
                                                                                </select>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-orange-100 hover:bg-orange-200 text-orange-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Power Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl border-l-4 border-orange-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Power</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-orange-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-orange-600 hover:text-orange-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Power Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- SI Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">SI Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Watts</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="wattsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">SI power unit</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Kilowatts</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="kilowattsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1000 watts</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Megawatts</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="megawattsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Million watts</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Mechanical Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Mechanical Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Horsepower</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="horsepowerDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Mechanical HP</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Metric HP</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="metricHpDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">PS (Pferdestärke)</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">ft⋅lb/s</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="footPoundDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Foot-pounds/second</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Thermal Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Thermal Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">BTU/h</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="btuHourDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">British thermal units/hour</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">cal/s</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="calorieSecDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Calories per second</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Ton Refrig.</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="tonRefrigDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Refrigeration ton</div>
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
                <!-- Quick Power Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Power Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="power-example px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-value="1" data-from="horsepower_mechanical" data-to="watt">1 hp</button>
                                                            <button type="button" class="power-example px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-value="1000" data-from="watt" data-to="kilowatt">1000 W</button>
                                                            <button type="button" class="power-example px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-value="3412" data-from="btu_hour" data-to="watt">3412 BTU/h</button>
                                                            <button type="button" class="power-example px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-value="5" data-from="kilowatt" data-to="horsepower_mechanical">5 kW</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Power Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Power Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 hp</strong> = 745.7 W</div>
                                                        <div><strong>1 PS</strong> = 735.5 W</div>
                                                        <div><strong>1 kW</strong> = 3412 BTU/h</div>
                                                        <div><strong>1 BTU/h</strong> = 0.293 W</div>
                                                        <div><strong>1 cal/s</strong> = 4.184 W</div>
                                                        <div><strong>1 ft⋅lb/s</strong> = 1.356 W</div>
                                                        <div><strong>1 ton refrig.</strong> = 3.517 kW</div>
                                                        <div><strong>Boiler hp</strong> = 9.81 kW</div>
                                                        <div><strong>Light bulb</strong> = 60 W</div>
                                                        <div><strong>Microwave</strong> = 800 W</div>
                                                        <div><strong>Hair dryer</strong> = 1.5 kW</div>
                                                        <div><strong>Electric car</strong> = 100 kW</div>
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
                        const powerType = document.getElementById('powerType');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const wattsDisplay = document.getElementById('wattsDisplay');
                        const kilowattsDisplay = document.getElementById('kilowattsDisplay');
                        const megawattsDisplay = document.getElementById('megawattsDisplay');
                        const horsepowerDisplay = document.getElementById('horsepowerDisplay');
                        const metricHpDisplay = document.getElementById('metricHpDisplay');
                        const footPoundDisplay = document.getElementById('footPoundDisplay');
                        const btuHourDisplay = document.getElementById('btuHourDisplay');
                        const calorieSecDisplay = document.getElementById('calorieSecDisplay');
                        const tonRefrigDisplay = document.getElementById('tonRefrigDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Power conversion multipliers (to watts as base)
                        const powerMultipliers = {
                            watt: 1,
                            kilowatt: 1000,
                            megawatt: 1000000,
                            gigawatt: 1000000000,
                            milliwatt: 0.001,
                            horsepower_mechanical: 745.699872,
                            horsepower_metric: 735.49875,
                            horsepower_electric: 746,
                            horsepower_boiler: 9809.5,
                            btu_hour: 0.293071,
                            btu_minute: 17.5843,
                            btu_second: 1055.06,
                            calorie_second: 4.184,
                            kcal_hour: 1.163,
                            foot_pound_second: 1.355818,
                            erg_second: 1e-7,
                            joule_second: 1,
                            ton_refrigeration: 3516.85
                        };

                        const unitLabels = {
                            watt: 'W',
                            kilowatt: 'kW',
                            megawatt: 'MW',
                            gigawatt: 'GW',
                            milliwatt: 'mW',
                            horsepower_mechanical: 'hp',
                            horsepower_metric: 'PS',
                            horsepower_electric: 'hp (elec)',
                            horsepower_boiler: 'hp (boiler)',
                            btu_hour: 'BTU/h',
                            btu_minute: 'BTU/min',
                            btu_second: 'BTU/s',
                            calorie_second: 'cal/s',
                            kcal_hour: 'kcal/h',
                            foot_pound_second: 'ft⋅lb/s',
                            erg_second: 'erg/s',
                            joule_second: 'J/s',
                            ton_refrigeration: 'ton refrig'
                        };

                        const unitNames = {
                            watt: 'Watts',
                            kilowatt: 'Kilowatts',
                            megawatt: 'Megawatts',
                            gigawatt: 'Gigawatts',
                            milliwatt: 'Milliwatts',
                            horsepower_mechanical: 'Mechanical Horsepower',
                            horsepower_metric: 'Metric Horsepower',
                            horsepower_electric: 'Electric Horsepower',
                            horsepower_boiler: 'Boiler Horsepower',
                            btu_hour: 'BTU per Hour',
                            btu_minute: 'BTU per Minute',
                            btu_second: 'BTU per Second',
                            calorie_second: 'Calories per Second',
                            kcal_hour: 'Kilocalories per Hour',
                            foot_pound_second: 'Foot-Pounds per Second',
                            erg_second: 'Ergs per Second',
                            joule_second: 'Joules per Second',
                            ton_refrigeration: 'Tons of Refrigeration'
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
                                // Convert input to watts first
                                const inputInWatts = inputVal * powerMultipliers[from];
                                
                                // Convert watts to target unit
                                const result = inputInWatts / powerMultipliers[to];
                                
                                // Update primary output
                                output.textContent = formatNumber(result) + ' ' + unitLabels[to];
                                resultTitle.textContent = `${unitNames[to]} (${unitLabels[to]})`;
                                resultDescription.textContent = `${inputVal} ${unitLabels[from]} = ${formatNumber(result)} ${unitLabels[to]}`;

                                // Convert to all common units and display
                                const watts = inputInWatts;
                                wattsDisplay.textContent = formatNumber(watts);
                                kilowattsDisplay.textContent = formatNumber(watts / powerMultipliers.kilowatt);
                                megawattsDisplay.textContent = formatNumber(watts / powerMultipliers.megawatt);
                                horsepowerDisplay.textContent = formatNumber(watts / powerMultipliers.horsepower_mechanical);
                                metricHpDisplay.textContent = formatNumber(watts / powerMultipliers.horsepower_metric);
                                footPoundDisplay.textContent = formatNumber(watts / powerMultipliers.foot_pound_second);
                                btuHourDisplay.textContent = formatNumber(watts / powerMultipliers.btu_hour);
                                calorieSecDisplay.textContent = formatNumber(watts / powerMultipliers.calorie_second);
                                tonRefrigDisplay.textContent = formatNumber(watts / powerMultipliers.ton_refrigeration);

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Power';
                            resultDescription.textContent = 'Converted result';
                            wattsDisplay.textContent = '--';
                            kilowattsDisplay.textContent = '--';
                            megawattsDisplay.textContent = '--';
                            horsepowerDisplay.textContent = '--';
                            metricHpDisplay.textContent = '--';
                            footPoundDisplay.textContent = '--';
                            btuHourDisplay.textContent = '--';
                            calorieSecDisplay.textContent = '--';
                            tonRefrigDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'watt';
                            toUnit.value = 'kilowatt';
                            powerType.value = '';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
                        toUnit.addEventListener('change', convert);
                        powerType.addEventListener('change', convert);

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
                        const powerExamples = document.querySelectorAll('.power-example');
                        powerExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                powerExamples.forEach(btn => btn.classList.remove('bg-orange-100', 'text-orange-700'));
                                powerExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-orange-100', 'text-orange-700');
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
