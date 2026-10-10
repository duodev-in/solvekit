<x-tool-page-layout
    title="Dimes to Dollars Calculator - ConvertPro"
    description="Professional dimes to dollars calculator for coin conversion. Convert dime quantities to dollar amounts with detailed breakdown for counting and financial calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Dimes to Dollars Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Dimes Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="dimesValue" class="block text-sm font-semibold text-gray-700">
                                                                                    Number of Dimes
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="dimesValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter number of dimes (e.g., 25)"
                                                                                        step="1"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">dimes</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter the total number of dimes to convert</p>
                                                                            </div>

                                                                            <!-- Coin Type -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Coin Type
                                                                                </label>
                                                                                <select 
                                                                                    id="coinType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="us_dime" selected>US Dime (10 cents)</option>
                                                                                    <option value="canadian_dime">Canadian Dime (10 cents)</option>
                                                                                    <option value="roosevelt_dime">Roosevelt Dime (1946-present)</option>
                                                                                    <option value="mercury_dime">Mercury Dime (1916-1945)</option>
                                                                                    <option value="barber_dime">Barber Dime (1892-1916)</option>
                                                                                    <option value="silver_dime">Silver Dime (Pre-1965)</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Calculation Method -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Calculation Method
                                                                                </label>
                                                                                <select 
                                                                                    id="calculationMethod" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="face_value" selected>Face Value Calculation</option>
                                                                                    <option value="melt_value">Silver Melt Value (Pre-1965)</option>
                                                                                    <option value="collector_value">Collector/Numismatic Value</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Silver Price (for melt value) -->
                                                                            <div class="space-y-2" id="silverPriceContainer" style="display: none;">
                                                                                <label for="silverPrice" class="block text-sm font-semibold text-gray-700">
                                                                                    Current Silver Price (per oz)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="silverPrice" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter silver price (e.g., 24.50)"
                                                                                        step="0.01"
                                                                                        min="0"
                                                                                        value="24.50"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">$/oz</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Current silver spot price per troy ounce</p>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Dime Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-blue-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Total Value in Dollars</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Enter a number of dimes to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-blue-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-blue-600 hover:text-blue-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Value Breakdown -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Face Value -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Face Value</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Dollars</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="dollarsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">USD amount</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cents</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="centsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Cent amount</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Per Dime</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="perDimeDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Value each</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Physical Properties -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Physical Properties</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Total Weight</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="totalWeightDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Grams</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Silver Content</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="silverContentDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Troy oz (if silver)</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Coin Era</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="coinEraDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Time period</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Equivalent Coins -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Equivalent Coins</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Pennies</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="penniesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">1¢ coins</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Nickels</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="nickelsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">5¢ coins</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Quarters</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="quartersDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">25¢ coins</div>
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
                <!-- Quick Dime Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Dime Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-dimes="10">10 dimes</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-dimes="25">25 dimes</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-dimes="50">50 dimes</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-dimes="100">100 dimes</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Dime Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 Dime</strong> = 10 cents</div>
                                                        <div><strong>10 Dimes</strong> = $1.00</div>
                                                        <div><strong>Weight</strong> = 2.268g</div>
                                                        <div><strong>Diameter</strong> = 17.91mm</div>
                                                        <div><strong>Roosevelt Dime</strong> = 1946-present</div>
                                                        <div><strong>Mercury Dime</strong> = 1916-1945</div>
                                                        <div><strong>Silver Content</strong> = 90% (pre-1965)</div>
                                                        <div><strong>Modern Dime</strong> = Copper-nickel</div>
                                                        <div><strong>Silver Weight</strong> = 0.0723 oz</div>
                                                        <div><strong>Collector Value</strong> = Variable</div>
                                                        <div><strong>Mint Mark</strong> = D, S, P</div>
                                                        <div><strong>Edge</strong> = Reeded</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dimesValue = document.getElementById('dimesValue');
                        const coinType = document.getElementById('coinType');
                        const calculationMethod = document.getElementById('calculationMethod');
                        const silverPrice = document.getElementById('silverPrice');
                        const silverPriceContainer = document.getElementById('silverPriceContainer');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const dollarsDisplay = document.getElementById('dollarsDisplay');
                        const centsDisplay = document.getElementById('centsDisplay');
                        const perDimeDisplay = document.getElementById('perDimeDisplay');
                        const totalWeightDisplay = document.getElementById('totalWeightDisplay');
                        const silverContentDisplay = document.getElementById('silverContentDisplay');
                        const coinEraDisplay = document.getElementById('coinEraDisplay');
                        const penniesDisplay = document.getElementById('penniesDisplay');
                        const nickelsDisplay = document.getElementById('nickelsDisplay');
                        const quartersDisplay = document.getElementById('quartersDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Dime specifications
                        const dimeSpecs = {
                            us_dime: {
                                weight: 2.268, // grams
                                diameter: '17.91mm',
                                thickness: '1.35mm',
                                composition: 'Cu-Ni clad',
                                era: '1965-present',
                                minted: '1965-present',
                                silverContent: 0
                            },
                            canadian_dime: {
                                weight: 1.75,
                                diameter: '18.03mm',
                                thickness: '1.22mm',
                                composition: 'Ni-plated steel',
                                era: '2000-present',
                                minted: '1858-present',
                                silverContent: 0
                            },
                            roosevelt_dime: {
                                weight: 2.268,
                                diameter: '17.91mm',
                                thickness: '1.35mm',
                                composition: 'Cu-Ni clad',
                                era: '1946-present',
                                minted: '1946-present',
                                silverContent: 0
                            },
                            mercury_dime: {
                                weight: 2.5,
                                diameter: '17.91mm',
                                thickness: '1.35mm',
                                composition: '90% silver',
                                era: '1916-1945',
                                minted: '1916-1945',
                                silverContent: 0.0723 // troy oz
                            },
                            barber_dime: {
                                weight: 2.5,
                                diameter: '17.91mm',
                                thickness: '1.35mm',
                                composition: '90% silver',
                                era: '1892-1916',
                                minted: '1892-1916',
                                silverContent: 0.0723
                            },
                            silver_dime: {
                                weight: 2.5,
                                diameter: '17.91mm',
                                thickness: '1.35mm',
                                composition: '90% silver',
                                era: 'Pre-1965',
                                minted: '1796-1964',
                                silverContent: 0.0723
                            }
                        };

                        function formatNumber(num, decimals = 2) {
                            return num.toLocaleString('en-US', { 
                                maximumFractionDigits: decimals, 
                                minimumFractionDigits: decimals 
                            });
                        }

                        function updateSilverPriceVisibility() {
                            const method = calculationMethod.value;
                            silverPriceContainer.style.display = method === 'melt_value' ? 'block' : 'none';
                        }

                        function calculate() {
                            const dimes = parseInt(dimesValue.value, 10);
                            const type = coinType.value;
                            const method = calculationMethod.value;
                            const currentSilverPrice = parseFloat(silverPrice.value) || 24.50;
                            
                            if (!Number.isNaN(dimes) && dimes >= 0) {
                                const specs = dimeSpecs[type];
                                const faceValue = dimes * 0.10; // 10 cents per dime
                                let totalValue = faceValue;
                                let perDimeValue = 0.10;

                                // Calculate value based on method
                                if (method === 'melt_value' && specs.silverContent > 0) {
                                    const totalSilverOz = dimes * specs.silverContent;
                                    totalValue = totalSilverOz * currentSilverPrice;
                                    perDimeValue = specs.silverContent * currentSilverPrice;
                                } else if (method === 'collector_value') {
                                    // Simplified collector value (would vary greatly in reality)
                                    if (type === 'mercury_dime') {
                                        totalValue = dimes * 2.50; // Example collector premium
                                        perDimeValue = 2.50;
                                    } else if (type === 'barber_dime') {
                                        totalValue = dimes * 5.00;
                                        perDimeValue = 5.00;
                                    } else {
                                        totalValue = faceValue;
                                        perDimeValue = 0.10;
                                    }
                                }

                                // Update primary output
                                output.textContent = '$' + formatNumber(totalValue);
                                resultTitle.textContent = method === 'face_value' ? 'Face Value in Dollars' : 
                                                        method === 'melt_value' ? 'Melt Value in Dollars' : 'Collector Value in Dollars';
                                resultDescription.textContent = `${dimes.toLocaleString('en-US')} ${dimes === 1 ? 'dime' : 'dimes'} = $${formatNumber(totalValue)}`;

                                // Display breakdowns
                                dollarsDisplay.textContent = '$' + formatNumber(totalValue);
                                centsDisplay.textContent = Math.round(totalValue * 100) + '¢';
                                perDimeDisplay.textContent = '$' + formatNumber(perDimeValue);

                                // Physical properties
                                const totalWeight = dimes * specs.weight;
                                totalWeightDisplay.textContent = formatNumber(totalWeight, 1) + 'g';
                                
                                if (specs.silverContent > 0) {
                                    const totalSilverOz = dimes * specs.silverContent;
                                    silverContentDisplay.textContent = formatNumber(totalSilverOz, 4) + ' oz';
                                } else {
                                    silverContentDisplay.textContent = 'No silver';
                                }
                                
                                coinEraDisplay.textContent = specs.era;

                                // Equivalent coins
                                penniesDisplay.textContent = dimes * 10; // 10 pennies per dime
                                nickelsDisplay.textContent = dimes * 2; // 2 nickels per dime
                                quartersDisplay.textContent = formatNumber(dimes / 2.5, 1); // 2.5 dimes per quarter

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Total Value in Dollars';
                            resultDescription.textContent = 'Enter a number of dimes to convert';
                            dollarsDisplay.textContent = '--';
                            centsDisplay.textContent = '--';
                            perDimeDisplay.textContent = '--';
                            totalWeightDisplay.textContent = '--';
                            silverContentDisplay.textContent = '--';
                            coinEraDisplay.textContent = '--';
                            penniesDisplay.textContent = '--';
                            nickelsDisplay.textContent = '--';
                            quartersDisplay.textContent = '--';
                        }

                        function clearAll() {
                            dimesValue.value = '';
                            coinType.value = 'us_dime';
                            calculationMethod.value = 'face_value';
                            silverPrice.value = '24.50';
                            updateSilverPriceVisibility();
                            clearOutputs();
                            dimesValue.focus();
                        }

                        // Event listeners
                        dimesValue.addEventListener('input', calculate);
                        coinType.addEventListener('change', calculate);
                        calculationMethod.addEventListener('change', function() {
                            updateSilverPriceVisibility();
                            calculate();
                        });
                        silverPrice.addEventListener('input', calculate);

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
                        const exampleBtns = document.querySelectorAll('.example-btn');
                        exampleBtns.forEach(button => {
                            button.addEventListener('click', function() {
                                const dimes = this.getAttribute('data-dimes');
                                
                                dimesValue.value = dimes;
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-blue-100', 'text-blue-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-blue-100', 'text-blue-700');
                            });
                        });

                        // Clickable examples
                        const examples = document.querySelectorAll('[data-dimes]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const dimes = this.getAttribute('data-dimes');
                                
                                if (dimes) {
                                    dimesValue.value = dimes;
                                    calculate();
                                    dimesValue.focus();
                                }
                            });
                        });

                        // Initialize
                        updateSilverPriceVisibility();
                        dimesValue.focus();

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
