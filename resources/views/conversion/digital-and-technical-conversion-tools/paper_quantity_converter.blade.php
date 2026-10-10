<x-tool-page-layout
    title="Paper Quantity Converter - ConvertPro"
    description="Professional paper quantity converter for ream, sheet, and paper conversions. Calculate printing costs, office supply quantities, and paper weight conversions for business needs."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Paper Quantity Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Type -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Type
                                                                                </label>
                                                                                <select 
                                                                                    id="conversionType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="quantity" selected>Paper Quantity Conversion</option>
                                                                                    <option value="weight">Paper Weight Conversion</option>
                                                                                    <option value="cost">Cost Calculation</option>
                                                                                    <option value="dimension">Paper Size & Dimensions</option>
                                                                                    <option value="printing">Printing Calculation</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Input Quantity -->
                                                                            <div class="space-y-2" id="quantityInputContainer">
                                                                                <label for="inputQuantity" class="block text-sm font-semibold text-gray-700" id="quantityLabel">
                                                                                    Number of Sheets
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputQuantity" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter quantity (e.g., 500)"
                                                                                        step="1"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="quantityUnit">sheets</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="quantityHint">Enter paper quantity for conversion</p>
                                                                            </div>

                                                                            <!-- Paper Size -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Paper Size
                                                                                </label>
                                                                                <select 
                                                                                    id="paperSize" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <optgroup label="ISO A Series">
                                                                                        <option value="A4" selected>A4 (210×297mm)</option>
                                                                                        <option value="A3">A3 (297×420mm)</option>
                                                                                        <option value="A5">A5 (148×210mm)</option>
                                                                                        <option value="A0">A0 (841×1189mm)</option>
                                                                                        <option value="A1">A1 (594×841mm)</option>
                                                                                        <option value="A2">A2 (420×594mm)</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="North American">
                                                                                        <option value="Letter">Letter (8.5×11")</option>
                                                                                        <option value="Legal">Legal (8.5×14")</option>
                                                                                        <option value="Ledger">Ledger (11×17")</option>
                                                                                        <option value="Executive">Executive (7.25×10.5")</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Other Standards">
                                                                                        <option value="B4">B4 (250×353mm)</option>
                                                                                        <option value="B5">B5 (176×250mm)</option>
                                                                                        <option value="Folio">Folio (8.5×13")</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Paper Weight/GSM -->
                                                                            <div class="space-y-2" id="paperWeightContainer">
                                                                                <label for="paperWeight" class="block text-sm font-semibold text-gray-700">
                                                                                    Paper Weight (GSM)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="paperWeight" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Paper weight"
                                                                                        step="any"
                                                                                        min="10"
                                                                                        max="500"
                                                                                        value="80"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">g/m²</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Grams per square meter (typical office paper: 80 GSM)</p>
                                                                            </div>

                                                                            <!-- Cost Per Unit -->
                                                                            <div class="space-y-2" id="costInputContainer" style="display: none;">
                                                                                <label for="costPerUnit" class="block text-sm font-semibold text-gray-700">
                                                                                    Cost Per Ream
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="costPerUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Cost per ream"
                                                                                        step="0.01"
                                                                                        min="0"
                                                                                        value="5.99"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">$</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Price per 500-sheet ream</p>
                                                                            </div>

                                                                            <!-- Paper Type -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Paper Type
                                                                                </label>
                                                                                <select 
                                                                                    id="paperType" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="copy" selected>Copy Paper (80 GSM)</option>
                                                                                    <option value="bond">Bond Paper (90 GSM)</option>
                                                                                    <option value="cardstock">Cardstock (200 GSM)</option>
                                                                                    <option value="photo">Photo Paper (250 GSM)</option>
                                                                                    <option value="newsprint">Newsprint (45 GSM)</option>
                                                                                    <option value="bristol">Bristol Board (300 GSM)</option>
                                                                                    <option value="tissue">Tissue Paper (20 GSM)</option>
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Paper Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl border-l-4 border-orange-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Number of Sheets</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Enter a quantity to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-orange-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-orange-600 hover:text-orange-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Paper Quantity Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Quantity Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Quantity Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Sheets</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="sheetsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Individual sheets</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Reams</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="reamsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">500 sheets each</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cases</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="casesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">5 reams (2500 sheets)</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Weight & Dimensions -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Physical Properties</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Total Weight</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="totalWeightDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Kilograms</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Stack Height</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="stackHeightDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Approximate height</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Paper Area</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="paperAreaDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Total surface area</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Cost Analysis -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Cost Analysis</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Total Cost</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="totalCostDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Based on unit price</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg border-l-4 border-amber-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Cost Per Sheet</h5>
                                                                                            <div class="text-lg font-bold text-amber-600 font-mono" id="costPerSheetDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Individual sheet cost</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Bulk Savings</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="bulkSavingsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Volume discount</div>
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
                <!-- Quick Paper Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Paper Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-quantity="500" data-type="quantity">1 Ream</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-quantity="5000" data-type="quantity">10 Reams</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-quantity="2500" data-type="quantity">Case (5 Reams)</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-orange-100 text-gray-700 hover:text-orange-700 rounded-lg transition-colors" data-quantity="1000" data-type="printing">1000 Pages</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Paper Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>1 Ream</strong> = 500 sheets</div>
                                                        <div><strong>1 Case</strong> = 5 reams (2500 sheets)</div>
                                                        <div><strong>A4 size</strong> = 210×297mm</div>
                                                        <div><strong>Letter size</strong> = 8.5×11 inches</div>
                                                        <div><strong>Copy paper</strong> = 80 GSM typical</div>
                                                        <div><strong>Cardstock</strong> = 200+ GSM</div>
                                                        <div><strong>1 sheet thickness</strong> ≈ 0.1mm (80 GSM)</div>
                                                        <div><strong>1 ream weight</strong> ≈ 2.5kg (A4, 80 GSM)</div>
                                                        <div><strong>1 tree</strong> ≈ 8,333 sheets</div>
                                                        <div><strong>Recycled content</strong> reduces impact</div>
                                                        <div><strong>Double-sided</strong> = 50% paper savings</div>
                                                        <div><strong>Digital first</strong> = best sustainability</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const conversionType = document.getElementById('conversionType');
                        const inputQuantity = document.getElementById('inputQuantity');
                        const paperSize = document.getElementById('paperSize');
                        const paperWeight = document.getElementById('paperWeight');
                        const costPerUnit = document.getElementById('costPerUnit');
                        const paperType = document.getElementById('paperType');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Container elements
                        const costInputContainer = document.getElementById('costInputContainer');
                        const quantityLabel = document.getElementById('quantityLabel');
                        const quantityUnit = document.getElementById('quantityUnit');
                        const quantityHint = document.getElementById('quantityHint');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const sheetsDisplay = document.getElementById('sheetsDisplay');
                        const reamsDisplay = document.getElementById('reamsDisplay');
                        const casesDisplay = document.getElementById('casesDisplay');
                        const totalWeightDisplay = document.getElementById('totalWeightDisplay');
                        const stackHeightDisplay = document.getElementById('stackHeightDisplay');
                        const paperAreaDisplay = document.getElementById('paperAreaDisplay');
                        const totalCostDisplay = document.getElementById('totalCostDisplay');
                        const costPerSheetDisplay = document.getElementById('costPerSheetDisplay');
                        const bulkSavingsDisplay = document.getElementById('bulkSavingsDisplay');
                        const copyResult = document.getElementById('copyResult');

                        // Paper size dimensions (mm for ISO, inches for US)
                        const paperSizes = {
                            'A4': { width: 210, height: 297, unit: 'mm', area: 0.0624 }, // m²
                            'A3': { width: 297, height: 420, unit: 'mm', area: 0.1247 },
                            'A5': { width: 148, height: 210, unit: 'mm', area: 0.0311 },
                            'A0': { width: 841, height: 1189, unit: 'mm', area: 1.0 },
                            'A1': { width: 594, height: 841, unit: 'mm', area: 0.4995 },
                            'A2': { width: 420, height: 594, unit: 'mm', area: 0.2494 },
                            'Letter': { width: 8.5, height: 11, unit: 'in', area: 0.0603 },
                            'Legal': { width: 8.5, height: 14, unit: 'in', area: 0.0767 },
                            'Ledger': { width: 11, height: 17, unit: 'in', area: 0.1206 },
                            'Executive': { width: 7.25, height: 10.5, unit: 'in', area: 0.0491 },
                            'B4': { width: 250, height: 353, unit: 'mm', area: 0.0883 },
                            'B5': { width: 176, height: 250, unit: 'mm', area: 0.044 },
                            'Folio': { width: 8.5, height: 13, unit: 'in', area: 0.0713 }
                        };

                        // Paper type GSM defaults
                        const paperTypes = {
                            copy: 80,
                            bond: 90,
                            cardstock: 200,
                            photo: 250,
                            newsprint: 45,
                            bristol: 300,
                            tissue: 20
                        };

                        function formatNumber(num, decimals = 2) {
                            if (!Number.isFinite(num)) {
                                return '--';
                            }

                            const abs = Math.abs(num);

                            if (abs !== 0 && abs < Math.pow(10, -decimals)) {
                                return num.toLocaleString('en-US', { maximumSignificantDigits: 3 });
                            }

                            return num.toLocaleString('en-US', {
                                maximumFractionDigits: decimals,
                                minimumFractionDigits: 0
                            });
                        }

                        function describeInput(type, quantity, size, weight, cost, sheets) {
                            switch (type) {
                                case 'weight':
                                    return `${formatNumber(quantity, 3)} kg of ${size} paper at ${formatNumber(weight, 0)} GSM`;
                                case 'cost':
                                    return `${formatNumber(quantity, 0)} sheets at $${formatNumber(cost, 2)} per ream`;
                                case 'dimension':
                                    return `${formatNumber(quantity, 0)} sheets of ${size} paper`;
                                case 'printing':
                                    return `${formatNumber(quantity, 0)} pages on ${size} paper`;
                                default:
                                    return `${formatNumber(quantity, 0)} sheets = ${formatNumber(sheets / 500, 3)} reams`;
                            }
                        }

                        function updateInputLabels() {
                            const type = conversionType.value;
                            
                            costInputContainer.style.display = (type === 'cost') ? 'block' : 'none';
                            
                            switch(type) {
                                case 'quantity':
                                    quantityLabel.textContent = 'Number of Sheets';
                                    quantityUnit.textContent = 'sheets';
                                    quantityHint.textContent = 'Enter number of sheets for conversion';
                                    break;
                                case 'weight':
                                    quantityLabel.textContent = 'Paper Weight';
                                    quantityUnit.textContent = 'kg';
                                    quantityHint.textContent = 'Enter total paper weight in kilograms';
                                    break;
                                case 'cost':
                                    quantityLabel.textContent = 'Number of Sheets';
                                    quantityUnit.textContent = 'sheets';
                                    quantityHint.textContent = 'Enter sheets for cost calculation';
                                    break;
                                case 'dimension':
                                    quantityLabel.textContent = 'Number of Sheets';
                                    quantityUnit.textContent = 'sheets';
                                    quantityHint.textContent = 'Enter sheets for dimension analysis';
                                    break;
                                case 'printing':
                                    quantityLabel.textContent = 'Pages to Print';
                                    quantityUnit.textContent = 'pages';
                                    quantityHint.textContent = 'Enter number of pages for printing';
                                    break;
                            }
                        }

                        function calculate() {
                            const type = conversionType.value;
                            const quantity = parseFloat(inputQuantity.value);
                            const size = paperSize.value;
                            const weight = parseFloat(paperWeight.value) || paperTypes[paperType.value] || 80;
                            const cost = parseFloat(costPerUnit.value) || 5.99;
                            
                            if (!isNaN(quantity) && quantity > 0) {
                                let sheets = 0;
                                
                                // Convert input to sheets based on type
                                switch(type) {
                                    case 'quantity':
                                    case 'cost':
                                    case 'dimension':
                                    case 'printing':
                                        sheets = quantity;
                                        break;
                                    case 'weight':
                                        // Calculate sheets from weight
                                        const sizeData = paperSizes[size];
                                        const sheetWeight = (weight / 1000) * sizeData.area; // kg per sheet
                                        sheets = quantity / sheetWeight;
                                        break;
                                }
                                
                                // Update primary output
                                if (type === 'cost') {
                                    const totalCost = (sheets / 500) * cost;
                                    output.textContent = '$' + formatNumber(totalCost, 2);
                                    resultTitle.textContent = 'Total Cost (USD)';
                                } else {
                                    output.textContent = formatNumber(sheets, 0) + ' sheets';
                                    resultTitle.textContent = 'Number of Sheets';
                                }
                                resultDescription.textContent = describeInput(type, quantity, size, weight, cost, sheets);

                                // Display quantity units
                                sheetsDisplay.textContent = formatNumber(sheets, 0);
                                reamsDisplay.textContent = formatNumber(sheets / 500, 2);
                                casesDisplay.textContent = formatNumber(sheets / 2500, 2);

                                // Physical properties
                                const sizeData = paperSizes[size];
                                const totalWeight = (sheets * weight * sizeData.area) / 1000; // kg
                                const sheetThickness = weight * 0.00125; // mm (approximate)
                                const stackHeight = sheets * sheetThickness; // mm
                                const totalArea = sheets * sizeData.area; // m²

                                totalWeightDisplay.textContent = formatNumber(totalWeight, 1) + ' kg';
                                
                                if (stackHeight > 1000) {
                                    stackHeightDisplay.textContent = formatNumber(stackHeight / 1000, 2) + ' m';
                                } else {
                                    stackHeightDisplay.textContent = formatNumber(stackHeight, 0) + ' mm';
                                }
                                
                                paperAreaDisplay.textContent = formatNumber(totalArea, 1) + ' m²';

                                // Cost analysis
                                const reamsNeeded = Math.ceil(sheets / 500);
                                const totalCost = reamsNeeded * cost;
                                const costPerSheet = cost / 500;
                                const bulkDiscount = reamsNeeded > 10 ? '10% bulk discount' : 'No bulk discount';

                                totalCostDisplay.textContent = '$' + formatNumber(totalCost, 2);
                                costPerSheetDisplay.textContent = '$' + formatNumber(costPerSheet, 4);
                                bulkSavingsDisplay.textContent = bulkDiscount;
                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Number of Sheets';
                            resultDescription.textContent = 'Enter a quantity to convert';
                            sheetsDisplay.textContent = '--';
                            reamsDisplay.textContent = '--';
                            casesDisplay.textContent = '--';
                            totalWeightDisplay.textContent = '--';
                            stackHeightDisplay.textContent = '--';
                            paperAreaDisplay.textContent = '--';
                            totalCostDisplay.textContent = '--';
                            costPerSheetDisplay.textContent = '--';
                            bulkSavingsDisplay.textContent = '--';
                        }

                        function clearAll() {
                            inputQuantity.value = '';
                            conversionType.value = 'quantity';
                            paperSize.value = 'A4';
                            paperWeight.value = '80';
                            costPerUnit.value = '5.99';
                            paperType.value = 'copy';
                            updateInputLabels();
                            clearOutputs();
                            inputQuantity.focus();
                        }

                        // Event listeners
                        conversionType.addEventListener('change', function() {
                            updateInputLabels();
                            calculate();
                        });
                        
                        inputQuantity.addEventListener('input', calculate);
                        paperSize.addEventListener('change', calculate);
                        paperWeight.addEventListener('input', calculate);
                        costPerUnit.addEventListener('input', calculate);
                        paperType.addEventListener('change', function() {
                            paperWeight.value = paperTypes[this.value] || 80;
                            calculate();
                        });

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
                                const quantity = this.getAttribute('data-quantity');
                                const type = this.getAttribute('data-type');
                                
                                inputQuantity.value = quantity;
                                conversionType.value = type;
                                updateInputLabels();
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-orange-100', 'text-orange-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-orange-100', 'text-orange-700');
                            });
                        });

                        // Clickable examples
                        const examples = document.querySelectorAll('[data-quantity][data-type]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const quantity = this.getAttribute('data-quantity');
                                const type = this.getAttribute('data-type');
                                
                                if (quantity && type) {
                                    inputQuantity.value = quantity;
                                    conversionType.value = type;
                                    updateInputLabels();
                                    calculate();
                                    inputQuantity.focus();
                                }
                            });
                        });

                        // Initialize
                        updateInputLabels();
                        inputQuantity.focus();

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
