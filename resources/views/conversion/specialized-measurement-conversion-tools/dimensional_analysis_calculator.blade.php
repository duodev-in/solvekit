<x-tool-page-layout
    title="Dimensional Analysis Calculator - ConvertPro"
    description="Professional dimensional analysis calculator for complex unit conversions and dimensional relationships. Analyze compound units, verify dimensional consistency, and perform advanced unit calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Dimensional Analysis Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Input Expression -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputExpression" class="block text-sm font-semibold text-gray-700">
                                                                                    Enter Unit Expression
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="text" 
                                                                                        id="inputExpression" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="e.g., 50 m/s², 100 kg⋅m/s², 25 N⋅m"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Expression</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Enter value with compound units (e.g., kg⋅m/s², N/m², J/kg)</p>
                                                                            </div>

                                                                           <!-- Target Units -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label for="targetUnits" class="block text-sm font-semibold text-gray-700">
                                                                                    Target Units (Optional)
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="text" 
                                                                                        id="targetUnits" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="e.g., ft/s², lb⋅ft/s², ft⋅lb"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">Target</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Leave blank for dimensional analysis only</p>
                                                                            </div>

                                                                            <!-- Analysis Mode -->
                                                                            <div class="space-y-2 hidden">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Analysis Mode
                                                                                </label>
                                                                                <select 
                                                                                    id="analysisMode" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="full_analysis" selected>Full Dimensional Analysis</option>
                                                                                    <option value="unit_conversion">Unit Conversion Only</option>
                                                                                    <option value="dimension_check">Dimension Verification</option>
                                                                                    <option value="base_units">Base Unit Breakdown</option>
                                                                                    <option value="physics_quantities">Physics Quantity Identification</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Unit System -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Preferred Unit System
                                                                                </label>
                                                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer bg-teal-50 border-teal-300">
                                                                                        <input type="radio" name="unitSystem" value="si" class="text-teal-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">SI (Metric)</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="unitSystem" value="imperial" class="text-teal-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Imperial</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="unitSystem" value="cgs" class="text-teal-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">CGS</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-teal-100 hover:bg-teal-200 text-teal-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Dimensional Analysis Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl border-l-4 border-teal-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Analysis Result</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Enter expression for analysis</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-teal-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-teal-600 hover:text-teal-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Dimensional Analysis -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Base Dimensions -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Base Dimensions</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Mass [M]</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="massExponent">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">kg, g, lb</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Length [L]</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="lengthExponent">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">m, ft, in</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Time [T]</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="timeExponent">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">s, min, hr</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Temperature [Θ]</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="temperatureExponent">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">K, °C, °F</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Additional Dimensions -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Extended Dimensions</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Current [I]</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="currentExponent">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">A, mA</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border-l-4 border-indigo-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Amount [N]</h5>
                                                                                            <div class="text-lg font-bold text-indigo-600 font-mono" id="amountExponent">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">mol</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Luminosity [J]</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="luminosityExponent">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">cd</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Dimensionless</h5>
                                                                                            <div class="text-lg font-bold text-cyan-600 font-mono" id="dimensionlessCheck">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">No units</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="hidden">
                                                                                <!-- Physics Quantity Identification -->
                                                                                <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-200">
                                                                                    <h4 class="text-sm font-semibold text-indigo-800 mb-2 text-center">Physics Quantity Identification</h4>
                                                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Quantity Type:</span>
                                                                                            <span class="font-mono text-indigo-700" id="quantityType">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Common Name:</span>
                                                                                            <span class="font-mono text-indigo-700" id="quantityName">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">SI Base Unit:</span>
                                                                                            <span class="font-mono text-indigo-700" id="siBaseUnit">--</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Unit Breakdown -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border border-green-200">
                                                                                    <h4 class="text-sm font-semibold text-green-800 mb-2 text-center">Unit Breakdown</h4>
                                                                                    <div class="space-y-2">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block text-sm">Original Expression:</span>
                                                                                            <span class="font-mono text-green-700 text-lg" id="originalExpression">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block text-sm">Base Unit Form:</span>
                                                                                            <span class="font-mono text-green-700 text-lg" id="baseUnitForm">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block text-sm">Dimensional Formula:</span>
                                                                                            <span class="font-mono text-green-700 text-lg" id="dimensionalFormula">--</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Conversion Results -->
                                                                                <div class="p-4 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-lg border border-amber-200">
                                                                                    <h4 class="text-sm font-semibold text-amber-800 mb-2 text-center">Alternative Unit Systems</h4>
                                                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">SI Units:</span>
                                                                                            <span class="font-mono text-amber-700" id="siUnits">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Imperial Units:</span>
                                                                                            <span class="font-mono text-amber-700" id="imperialUnits">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">CGS Units:</span>
                                                                                            <span class="font-mono text-amber-700" id="cgsUnits">--</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Related Quantities -->
                                                                                <div class="p-4 bg-gradient-to-r from-rose-50 to-pink-50 rounded-lg border border-rose-200">
                                                                                    <h4 class="text-sm font-semibold text-rose-800 mb-2 text-center">Related Physical Quantities</h4>
                                                                                    <div class="text-sm text-rose-700 text-center" id="relatedQuantities">--</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Unit Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick Unit Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="unit-example px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-gray-700 hover:text-teal-700 rounded-lg transition-colors" data-expression="9.8 m/s²">Acceleration</button>
                                                            <button type="button" class="unit-example px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-gray-700 hover:text-teal-700 rounded-lg transition-colors" data-expression="500 N⋅m">Torque</button>
                                                            <button type="button" class="unit-example px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-gray-700 hover:text-teal-700 rounded-lg transition-colors" data-expression="1000 kg⋅m/s²">Force</button>
                                                            <button type="button" class="unit-example px-3 py-2 text-sm bg-gray-100 hover:bg-teal-100 text-gray-700 hover:text-teal-700 rounded-lg transition-colors" data-expression="1000 J">Energy</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Unit Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Dimensional Analysis Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>[M]:</strong> Mass dimension</div>
                                                        <div><strong>[L]:</strong> Length dimension</div>
                                                        <div><strong>[T]:</strong> Time dimension</div>
                                                        <div><strong>[Θ]:</strong> Temperature dimension</div>
                                                        <div><strong>[I]:</strong> Electric current</div>
                                                        <div><strong>[N]:</strong> Amount of substance</div>
                                                        <div><strong>[J]:</strong> Luminous intensity</div>
                                                        <div><strong>Force:</strong> [M L T⁻²]</div>
                                                        <div><strong>Energy:</strong> [M L² T⁻²]</div>
                                                        <div><strong>Power:</strong> [M L² T⁻³]</div>
                                                        <div><strong>Pressure:</strong> [M L⁻¹ T⁻²]</div>
                                                        <div><strong>Velocity:</strong> [L T⁻¹]</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputExpression = document.getElementById('inputExpression');
                        const targetUnits = document.getElementById('targetUnits');
                        const analysisMode = document.getElementById('analysisMode');
                        const unitSystemRadios = document.getElementsByName('unitSystem');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const massExponent = document.getElementById('massExponent');
                        const lengthExponent = document.getElementById('lengthExponent');
                        const timeExponent = document.getElementById('timeExponent');
                        const temperatureExponent = document.getElementById('temperatureExponent');
                        const currentExponent = document.getElementById('currentExponent');
                        const amountExponent = document.getElementById('amountExponent');
                        const luminosityExponent = document.getElementById('luminosityExponent');
                        const dimensionlessCheck = document.getElementById('dimensionlessCheck');
                        const quantityType = document.getElementById('quantityType');
                        const quantityName = document.getElementById('quantityName');
                        const siBaseUnit = document.getElementById('siBaseUnit');
                        const originalExpression = document.getElementById('originalExpression');
                        const baseUnitForm = document.getElementById('baseUnitForm');
                        const dimensionalFormula = document.getElementById('dimensionalFormula');
                        const siUnits = document.getElementById('siUnits');
                        const imperialUnits = document.getElementById('imperialUnits');
                        const cgsUnits = document.getElementById('cgsUnits');
                        const relatedQuantities = document.getElementById('relatedQuantities');
                        const copyResult = document.getElementById('copyResult');

                        // Unit database with dimensional analysis
                        const unitDatabase = {
                            // Basic SI units
                            'm': { dimension: [0, 1, 0, 0, 0, 0, 0], name: 'meter', type: 'length' },
                            'kg': { dimension: [1, 0, 0, 0, 0, 0, 0], name: 'kilogram', type: 'mass' },
                            's': { dimension: [0, 0, 1, 0, 0, 0, 0], name: 'second', type: 'time' },
                            'A': { dimension: [0, 0, 0, 0, 1, 0, 0], name: 'ampere', type: 'current' },
                            'K': { dimension: [0, 0, 0, 1, 0, 0, 0], name: 'kelvin', type: 'temperature' },
                            'mol': { dimension: [0, 0, 0, 0, 0, 1, 0], name: 'mole', type: 'amount' },
                            'cd': { dimension: [0, 0, 0, 0, 0, 0, 1], name: 'candela', type: 'luminosity' },
                            
                            // Derived units
                            'N': { dimension: [1, 1, -2, 0, 0, 0, 0], name: 'newton', type: 'force' },
                            'J': { dimension: [1, 2, -2, 0, 0, 0, 0], name: 'joule', type: 'energy' },
                            'W': { dimension: [1, 2, -3, 0, 0, 0, 0], name: 'watt', type: 'power' },
                            'Pa': { dimension: [1, -1, -2, 0, 0, 0, 0], name: 'pascal', type: 'pressure' },
                            'V': { dimension: [1, 2, -3, 0, -1, 0, 0], name: 'volt', type: 'voltage' },
                            'Hz': { dimension: [0, 0, -1, 0, 0, 0, 0], name: 'hertz', type: 'frequency' },
                            
                            // Imperial units
                            'ft': { dimension: [0, 1, 0, 0, 0, 0, 0], name: 'foot', type: 'length', factor: 0.3048 },
                            'lb': { dimension: [1, 0, 0, 0, 0, 0, 0], name: 'pound', type: 'mass', factor: 0.453592 },
                            'lbf': { dimension: [1, 1, -2, 0, 0, 0, 0], name: 'pound-force', type: 'force' },
                            
                            // Common compound units
                            'm/s': { dimension: [0, 1, -1, 0, 0, 0, 0], name: 'velocity', type: 'velocity' },
                            'm/s²': { dimension: [0, 1, -2, 0, 0, 0, 0], name: 'acceleration', type: 'acceleration' },
                            'kg⋅m/s²': { dimension: [1, 1, -2, 0, 0, 0, 0], name: 'force', type: 'force' },
                            'N⋅m': { dimension: [1, 2, -2, 0, 0, 0, 0], name: 'torque', type: 'torque' }
                        };

                        const physicsQuantities = {
                            '[1,1,-2,0,0,0,0]': { name: 'Force', type: 'Mechanical', si: 'N', examples: ['Weight', 'Applied force', 'Tension'] },
                            '[1,2,-2,0,0,0,0]': { name: 'Energy/Work/Torque', type: 'Mechanical', si: 'J', examples: ['Kinetic energy', 'Potential energy', 'Heat'] },
                            '[1,2,-3,0,0,0,0]': { name: 'Power', type: 'Mechanical', si: 'W', examples: ['Engine power', 'Heat rate', 'Electrical power'] },
                            '[1,-1,-2,0,0,0,0]': { name: 'Pressure/Stress', type: 'Mechanical', si: 'Pa', examples: ['Atmospheric pressure', 'Stress', 'Strain'] },
                            '[0,1,-1,0,0,0,0]': { name: 'Velocity', type: 'Kinematic', si: 'm/s', examples: ['Speed', 'Velocity', 'Flow rate'] },
                            '[0,1,-2,0,0,0,0]': { name: 'Acceleration', type: 'Kinematic', si: 'm/s²', examples: ['Gravity', 'Angular acceleration'] },
                            '[0,0,-1,0,0,0,0]': { name: 'Frequency', type: 'Wave/Oscillation', si: 'Hz', examples: ['Wave frequency', 'Rotation rate'] },
                            '[1,2,-3,0,-1,0,0]': { name: 'Voltage', type: 'Electrical', si: 'V', examples: ['Electric potential', 'EMF'] }
                        };

                        function parseExpression(expression) {
                            // Simple parser for basic expressions like "50 m/s²", "100 N⋅m"
                            const match = expression.match(/^(-?\d*\.?\d+)\s*([^\d\s.].*)$/);
                            if (!match) return null;
                            
                            const value = parseFloat(match[1]);
                            const unitString = match[2].trim();
                            
                            return { value, units: unitString };
                        }

                        function analyzeDimensions(unitString) {
                            // Simplified dimensional analysis
                            const dimensions = [0, 0, 0, 0, 0, 0, 0]; // [M, L, T, Θ, I, N, J]
                            
                            // Handle common patterns
                            if (unitString.includes('kg⋅m/s²') || unitString === 'N') {
                                dimensions[0] = 1; dimensions[1] = 1; dimensions[2] = -2; // [M L T⁻²]
                            } else if (unitString.includes('m/s²')) {
                                dimensions[1] = 1; dimensions[2] = -2; // [L T⁻²]
                            } else if (unitString.includes('N⋅m') || unitString === 'J') {
                                dimensions[0] = 1; dimensions[1] = 2; dimensions[2] = -2; // [M L² T⁻²]
                            } else if (unitString.includes('m/s')) {
                                dimensions[1] = 1; dimensions[2] = -1; // [L T⁻¹]
                            } else if (unitString === 'W') {
                                dimensions[0] = 1; dimensions[1] = 2; dimensions[2] = -3; // [M L² T⁻³]
                            } else if (unitString === 'Pa') {
                                dimensions[0] = 1; dimensions[1] = -1; dimensions[2] = -2; // [M L⁻¹ T⁻²]
                            } else if (unitString === 'V') {
                                dimensions[0] = 1; dimensions[1] = 2; dimensions[2] = -3; dimensions[4] = -1; // [M L² T⁻³ I⁻¹]
                            } else if (unitString === 'Hz') {
                                dimensions[2] = -1; // [T⁻¹]
                            } else if (unitString === 'm') {
                                dimensions[1] = 1; // [L]
                            } else if (unitString === 'kg') {
                                dimensions[0] = 1; // [M]
                            } else if (unitString === 's') {
                                dimensions[2] = 1; // [T]
                            }
                            
                            return dimensions;
                        }

                        function getDimensionalFormula(dimensions) {
                            const symbols = ['M', 'L', 'T', 'Θ', 'I', 'N', 'J'];
                            let formula = '';
                            
                            for (let i = 0; i < dimensions.length; i++) {
                                if (dimensions[i] !== 0) {
                                    if (formula) formula += ' ';
                                    formula += symbols[i];
                                    if (dimensions[i] !== 1) {
                                        const superscripts = { '-': '⁻', '0': '⁰', '1': '¹', '2': '²', '3': '³', '4': '⁴', '5': '⁵', '6': '⁶', '7': '⁷', '8': '⁸', '9': '⁹' };
                                        formula += String(dimensions[i]).split('').map(character => superscripts[character] || character).join('');
                                    }
                                }
                            }
                            
                            return formula || 'Dimensionless';
                        }

                        function identifyQuantity(dimensions) {
                            const key = JSON.stringify(dimensions);
                            return physicsQuantities[key] || { name: 'Unknown', type: 'Unknown', si: 'Unknown', examples: [] };
                        }

                        function getRelatedQuantities(quantityInfo) {
                            if (quantityInfo.examples && quantityInfo.examples.length > 0) {
                                return quantityInfo.examples.join(', ');
                            }
                            return 'No related quantities found';
                        }

                        function analyze() {
                            const expression = inputExpression.value.trim();
                            const mode = analysisMode.value;
                            const unitSystem = document.querySelector('input[name="unitSystem"]:checked').value;

                            if (!expression) {
                                clearOutputs();
                                return;
                            }

                            const parsed = parseExpression(expression);
                            if (!parsed) {
                                output.textContent = 'Invalid expression format';
                                resultTitle.textContent = 'Analysis Result';
                                resultDescription.textContent = 'Use format: "value units" (e.g., "50 m/s²")';
                                return;
                            }

                            const dimensions = analyzeDimensions(parsed.units);
                            const quantityInfo = identifyQuantity(dimensions);
                            const formula = getDimensionalFormula(dimensions);

                            // Update dimensional displays
                            massExponent.textContent = dimensions[0] || '0';
                            lengthExponent.textContent = dimensions[1] || '0';
                            timeExponent.textContent = dimensions[2] || '0';
                            temperatureExponent.textContent = dimensions[3] || '0';
                            currentExponent.textContent = dimensions[4] || '0';
                            amountExponent.textContent = dimensions[5] || '0';
                            luminosityExponent.textContent = dimensions[6] || '0';
                            
                            const isDimensionless = dimensions.every(d => d === 0);
                            dimensionlessCheck.textContent = isDimensionless ? 'Yes' : 'No';

                            // Update quantity identification
                            quantityType.textContent = quantityInfo.type;
                            quantityName.textContent = quantityInfo.name;
                            siBaseUnit.textContent = quantityInfo.si;

                            // Update unit breakdown
                            originalExpression.textContent = expression;
                            baseUnitForm.textContent = parsed.units;
                            dimensionalFormula.textContent = '[' + formula + ']';

                            // Update alternative units (simplified)
                            siUnits.textContent = quantityInfo.si !== 'Unknown' ? quantityInfo.si : parsed.units;
                            imperialUnits.textContent = 'Conversion needed';
                            cgsUnits.textContent = 'Conversion needed';

                            // Related quantities
                            relatedQuantities.textContent = getRelatedQuantities(quantityInfo);

                            // Primary output
                            output.textContent = parsed.value + ' ' + parsed.units;
                            resultTitle.textContent = quantityInfo.name + ' Analysis';
                            resultDescription.textContent = `${expression} → [${formula}]`;

                        } 

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = 'Analysis Result';
                            resultDescription.textContent = 'Enter expression for analysis';
                            massExponent.textContent = '--';
                            lengthExponent.textContent = '--';
                            timeExponent.textContent = '--';
                            temperatureExponent.textContent = '--';
                            currentExponent.textContent = '--';
                            amountExponent.textContent = '--';
                            luminosityExponent.textContent = '--';
                            dimensionlessCheck.textContent = '--';
                            quantityType.textContent = '--';
                            quantityName.textContent = '--';
                            siBaseUnit.textContent = '--';
                            originalExpression.textContent = '--';
                            baseUnitForm.textContent = '--';
                            dimensionalFormula.textContent = '--';
                            siUnits.textContent = '--';
                            imperialUnits.textContent = '--';
                            cgsUnits.textContent = '--';
                            relatedQuantities.textContent = '--';
                        }

                        function clearAll() {
                            inputExpression.value = '';
                            targetUnits.value = '';
                            analysisMode.value = 'full_analysis';
                            document.querySelector('input[value="si"]').checked = true;
                            clearOutputs();
                            inputExpression.focus();
                        }

                        // Event listeners
                        inputExpression.addEventListener('input', analyze);
                        targetUnits.addEventListener('input', analyze);
                        analysisMode.addEventListener('change', analyze);
                        
                        unitSystemRadios.forEach(radio => {
                            radio.addEventListener('change', analyze);
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
                        const unitExamples = document.querySelectorAll('.unit-example');
                        unitExamples.forEach(button => {
                            button.addEventListener('click', function() {
                                const expression = this.getAttribute('data-expression');
                                
                                inputExpression.value = expression;
                                analyze();
                                
                                // Update button styles
                                unitExamples.forEach(btn => btn.classList.remove('bg-teal-100', 'text-teal-700'));
                                unitExamples.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-teal-100', 'text-teal-700');
                            });
                        });

                        // Initialize
                        inputExpression.focus();

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
