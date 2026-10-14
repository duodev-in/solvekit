<x-tool-page-layout
    title="Hardness Conversion Calculator - SolveKit"
    description="Professional hardness conversion calculator for materials testing. Convert between Rockwell, Brinell, Vickers, Shore, and other hardness scales with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Hardness Conversion Calculator</h1>
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
                                                                                    Enter Hardness Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter hardness value (e.g., 60)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Value</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter hardness measurement value</p>
                                                                            </div>

                                                                            <!-- From Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    From Scale (Source)
                                                                                </label>
                                                                                <select 
                                                                                    id="fromUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="Rockwell Scales">
                                                                                        <option value="hrc" selected>HRC (Rockwell C Scale)</option>
                                                                                        <option value="hrb">HRB (Rockwell B Scale)</option>
                                                                                        <option value="hra">HRA (Rockwell A Scale)</option>
                                                                                        <option value="hr15n">HR15N (Rockwell 15N Scale)</option>
                                                                                        <option value="hr30n">HR30N (Rockwell 30N Scale)</option>
                                                                                        <option value="hr45n">HR45N (Rockwell 45N Scale)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Brinell Scale">
                                                                                        <option value="hb">HB (Brinell Hardness)</option>
                                                                                        <option value="hbw">HBW (Brinell Tungsten Ball)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Vickers Scale">
                                                                                        <option value="hv">HV (Vickers Hardness)</option>
                                                                                        <option value="hv1">HV1 (Vickers 1kg)</option>
                                                                                        <option value="hv5">HV5 (Vickers 5kg)</option>
                                                                                        <option value="hv10">HV10 (Vickers 10kg)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Shore Scales">
                                                                                        <option value="shore_a">Shore A (Soft plastics/rubber)</option>
                                                                                        <option value="shore_d">Shore D (Hard plastics)</option>
                                                                                        <option value="shore_00">Shore 00 (Very soft materials)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Knoop Scale">
                                                                                        <option value="hk">HK (Knoop Hardness)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Leeb Scale">
                                                                                        <option value="hl">HL (Leeb Hardness)</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            <!-- To Unit -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    To Scale (Target)
                                                                                </label>
                                                                                <select 
                                                                                    id="toUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="Rockwell Scales">
                                                                                        <option value="hrc">HRC (Rockwell C Scale)</option>
                                                                                        <option value="hrb" selected>HRB (Rockwell B Scale)</option>
                                                                                        <option value="hra">HRA (Rockwell A Scale)</option>
                                                                                        <option value="hr15n">HR15N (Rockwell 15N Scale)</option>
                                                                                        <option value="hr30n">HR30N (Rockwell 30N Scale)</option>
                                                                                        <option value="hr45n">HR45N (Rockwell 45N Scale)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Brinell Scale">
                                                                                        <option value="hb">HB (Brinell Hardness)</option>
                                                                                        <option value="hbw">HBW (Brinell Tungsten Ball)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Vickers Scale">
                                                                                        <option value="hv">HV (Vickers Hardness)</option>
                                                                                        <option value="hv1">HV1 (Vickers 1kg)</option>
                                                                                        <option value="hv5">HV5 (Vickers 5kg)</option>
                                                                                        <option value="hv10">HV10 (Vickers 10kg)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Shore Scales">
                                                                                        <option value="shore_a">Shore A (Soft plastics/rubber)</option>
                                                                                        <option value="shore_d">Shore D (Hard plastics)</option>
                                                                                        <option value="shore_00">Shore 00 (Very soft materials)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Knoop Scale">
                                                                                        <option value="hk">HK (Knoop Hardness)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Leeb Scale">
                                                                                        <option value="hl">HL (Leeb Hardness)</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            </div>

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Hardness Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl border-l-4 border-purple-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Hardness</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Converted result</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-purple-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-purple-600 hover:text-purple-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Hardness Scales Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Rockwell Scales -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Rockwell Scales</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">HRC</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="hrcDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Hard steels, tools</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">HRB</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="hrbDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Soft steels, aluminum</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">HRA</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="hraDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Carbides, thin sheets</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Other Scales -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Other Scales</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">HB (Brinell)</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="hbDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Cast iron, forgings</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">HV (Vickers)</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="hvDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Research, thin sections</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Shore D</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="shoreDDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Hard plastics</div>
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
                <!-- Quick Hardness Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Hardness Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="hardness-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="60" data-from="hrc" data-to="hrb">60 HRC</button>
                                                            <button type="button" class="hardness-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="85" data-from="hrb" data-to="hrc">85 HRB</button>
                                                            <button type="button" class="hardness-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="250" data-from="hb" data-to="hrc">250 HB</button>
                                                            <button type="button" class="hardness-example px-3 py-2 text-sm bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 rounded-lg transition-colors" data-value="300" data-from="hv" data-to="hrc">300 HV</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Hardness Scale Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Hardness Scale Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>HRC 20-25:</strong> Soft steel</div>
                                                        <div><strong>HRC 45-50:</strong> Medium carbon steel</div>
                                                        <div><strong>HRC 58-62:</strong> Tool steel</div>
                                                        <div><strong>HRC 65+:</strong> File hard</div>
                                                        <div><strong>HRB 60-85:</strong> Soft materials</div>
                                                        <div><strong>HRB 85-100:</strong> Medium materials</div>
                                                        <div><strong>HB 150-200:</strong> Mild steel</div>
                                                        <div><strong>HB 400+:</strong> Hard steel</div>
                                                        <div><strong>HV = HB:</strong> For most metals</div>
                                                        <div><strong>Shore A 20-80:</strong> Rubber</div>
                                                        <div><strong>Shore D 55-90:</strong> Hard plastics</div>
                                                        <div><strong>HL 200-900:</strong> Portable testing</div>
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
                        const hrcDisplay = document.getElementById('hrcDisplay');
                        const hrbDisplay = document.getElementById('hrbDisplay');
                        const hraDisplay = document.getElementById('hraDisplay');
                        const hbDisplay = document.getElementById('hbDisplay');
                        const hvDisplay = document.getElementById('hvDisplay');
                        const shoreDDisplay = document.getElementById('shoreDDisplay');
                        const copyResult = document.getElementById('copyResult');

                        const unitLabels = {
                            hrc: 'HRC',
                            hrb: 'HRB',
                            hra: 'HRA',
                            hr15n: 'HR15N',
                            hr30n: 'HR30N',
                            hr45n: 'HR45N',
                            hb: 'HB',
                            hbw: 'HBW',
                            hv: 'HV',
                            hv1: 'HV1',
                            hv5: 'HV5',
                            hv10: 'HV10',
                            shore_a: 'Shore A',
                            shore_d: 'Shore D',
                            shore_00: 'Shore 00',
                            hk: 'HK',
                            hl: 'HL'
                        };

                        // Hardness conversion functions (simplified approximations)
                        const scaleAliases = {
                            hbw: 'hb',
                            hv1: 'hv',
                            hv5: 'hv',
                            hv10: 'hv',
                            hk: 'hv'
                        };

                        const shoreScales = ['shore_a', 'shore_d', 'shore_00'];

                        function toShoreD(value, fromScale) {
                            if (fromScale === 'shore_00') {
                                return toShoreD(2 * value - 120, 'shore_a');
                            }
                            if (fromScale === 'shore_a') {
                                return 0.75 * value - 30;
                            }
                            return value;
                        }

                        function fromShoreD(shoreD, toScale) {
                            if (toScale === 'shore_a') {
                                return (shoreD + 30) / 0.75;
                            }
                            if (toScale === 'shore_00') {
                                return (fromShoreD(shoreD, 'shore_a') + 120) / 2;
                            }
                            return shoreD;
                        }

                        function convertToHRC(value, fromScale) {
                            switch(scaleAliases[fromScale] || fromScale) {
                                case 'hrc': return value;
                                case 'hrb': return value > 99 ? 20 + (value - 99) * 0.8 : Math.max(0, (value - 80) * 0.5);
                                case 'hra': return (value - 60) * 1.5;
                                case 'hr15n': return (value - 59) / 0.52;
                                case 'hr30n': return (value - 23.5) / 0.9;
                                case 'hr45n': return (value + 4.1) / 1.18;
                                case 'hb': return value < 100 ? 0 : Math.min(70, (value - 100) / 10 + 20);
                                case 'hv': return value < 150 ? 0 : Math.min(70, (value - 150) / 10 + 15);
                                case 'shore_a':
                                case 'shore_00':
                                case 'shore_d': {
                                    const shoreD = toShoreD(value, fromScale);
                                    return shoreD > 90 ? 50 + (shoreD - 90) * 2 : Math.max(0, (shoreD - 40) * 0.5);
                                }
                                case 'hl': return Math.min(70, Math.max(0, (value - 200) / 10));
                                default: return value;
                            }
                        }

                        function convertFromHRC(hrcValue, toScale) {
                            switch(scaleAliases[toScale] || toScale) {
                                case 'hrc': return hrcValue;
                                case 'hrb': return hrcValue < 20 ? 80 + hrcValue * 2 : Math.min(110, 99 + (hrcValue - 20) / 0.8);
                                case 'hra': return 60 + hrcValue / 1.5;
                                case 'hr15n': return 59 + hrcValue * 0.52;
                                case 'hr30n': return 23.5 + hrcValue * 0.9;
                                case 'hr45n': return -4.1 + hrcValue * 1.18;
                                case 'hb': return hrcValue < 20 ? 100 + hrcValue * 5 : 100 + (hrcValue - 20) * 10;
                                case 'hv': return hrcValue < 15 ? 150 + hrcValue * 5 : 150 + (hrcValue - 15) * 10;
                                case 'shore_a':
                                case 'shore_00':
                                case 'shore_d': {
                                    const shoreD = hrcValue < 50 ? 40 + hrcValue * 2 : Math.min(95, 90 + (hrcValue - 50) / 2);
                                    return Math.max(0, fromShoreD(shoreD, toScale));
                                }
                                case 'hl': return 200 + hrcValue * 10;
                                default: return hrcValue;
                            }
                        }

                        function convertHardness(value, fromScale, toScale) {
                            if (shoreScales.includes(fromScale) && shoreScales.includes(toScale)) {
                                return Math.max(0, fromShoreD(toShoreD(value, fromScale), toScale));
                            }
                            return convertFromHRC(convertToHRC(value, fromScale), toScale);
                        }

                        function formatNumber(num) {
                            if (!Number.isFinite(num)) {
                                return '--';
                            }
                            if (num !== 0 && Math.abs(num) < 1) {
                                return num.toPrecision(2);
                            }
                            return num.toLocaleString(undefined, { maximumFractionDigits: 1, minimumFractionDigits: 0 });
                        }

                        function convert() {
                            const inputVal = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(inputVal) && inputVal >= 0) {
                                // Convert to HRC as intermediate
                                const hrcValue = convertToHRC(inputVal, from);
                                
                                // Convert to target scale
                                const result = convertHardness(inputVal, from, to);
                                
                                // Update primary output
                                output.textContent = formatNumber(result) + ' ' + unitLabels[to];
                                resultTitle.textContent = toUnit.options[toUnit.selectedIndex].text;
                                resultDescription.textContent = `${formatNumber(inputVal)} ${unitLabels[from]} = ${formatNumber(result)} ${unitLabels[to]}`;

                                // Convert to all common scales and display
                                hrcDisplay.textContent = formatNumber(convertFromHRC(hrcValue, 'hrc'));
                                hrbDisplay.textContent = formatNumber(convertFromHRC(hrcValue, 'hrb'));
                                hraDisplay.textContent = formatNumber(convertFromHRC(hrcValue, 'hra'));
                                hbDisplay.textContent = formatNumber(convertFromHRC(hrcValue, 'hb'));
                                hvDisplay.textContent = formatNumber(convertFromHRC(hrcValue, 'hv'));
                                shoreDDisplay.textContent = formatNumber(convertFromHRC(hrcValue, 'shore_d'));

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Converted Hardness';
                            resultDescription.textContent = 'Converted result';
                            hrcDisplay.textContent = '--';
                            hrbDisplay.textContent = '--';
                            hraDisplay.textContent = '--';
                            hbDisplay.textContent = '--';
                            hvDisplay.textContent = '--';
                            shoreDDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            fromUnit.value = 'hrc';
                            toUnit.value = 'hrb';
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
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
                        const hardnessExamples = document.querySelectorAll('.hardness-example');
                        hardnessExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const from = this.getAttribute('data-from');
                                const to = this.getAttribute('data-to');
                                
                                inputValue.value = value;
                                fromUnit.value = from;
                                toUnit.value = to;
                                convert();
                                
                                // Update button styles
                                hardnessExamples.forEach(btn => btn.classList.remove('bg-purple-100', 'text-purple-700'));
                                hardnessExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-purple-100', 'text-purple-700');
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
