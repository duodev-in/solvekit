<x-tool-page-layout
    title="Px to Em Converter - ConvertPro"
    description="Professional px to em converter for CSS unit conversion. Convert pixels to em units for responsive web design and scalable typography with base font size calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Px to Em Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <select 
                                                                                    id="conversionDirection" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="px_to_em" selected>Pixels to Em</option>
                                                                                    <option value="em_to_px">Em to Pixels</option>
                                                                                    <option value="px_to_rem">Pixels to Rem</option>
                                                                                    <option value="rem_to_px">Rem to Pixels</option>
                                                                                    <option value="em_to_rem">Em to Rem</option>
                                                                                    <option value="rem_to_em">Rem to Em</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-gray-700" id="inputLabel">
                                                                                    Pixel Value
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Enter value (e.g., 16)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">px</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500" id="inputHint">Enter pixel value for conversion</p>
                                                                            </div>

                                                                            <!-- Base Font Size -->
                                                                            <div class="space-y-2">
                                                                                <label for="baseFontSize" class="block text-sm font-semibold text-gray-700">
                                                                                    Base Font Size
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="baseFontSize" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-mono" 
                                                                                        placeholder="Base font size"
                                                                                        step="any"
                                                                                        min="1"
                                                                                        value="16"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">px</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Root/parent element font size (typically 16px)</p>
                                                                            </div>

                                                                            <!-- Context -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    CSS Context
                                                                                </label>
                                                                                <select 
                                                                                    id="cssContext" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="font_size" selected>Font Size</option>
                                                                                    <option value="margin">Margin</option>
                                                                                    <option value="padding">Padding</option>
                                                                                    <option value="width">Width</option>
                                                                                    <option value="height">Height</option>
                                                                                    <option value="line_height">Line Height</option>
                                                                                    <option value="border_radius">Border Radius</option>
                                                                                    <option value="spacing">General Spacing</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Browser Preset -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Browser Preset
                                                                                </label>
                                                                                <select 
                                                                                    id="browserPreset" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="16" selected>Standard (16px)</option>
                                                                                    <option value="14">Small (14px)</option>
                                                                                    <option value="18">Large (18px)</option>
                                                                                    <option value="20">Extra Large (20px)</option>
                                                                                    <option value="12">Tiny (12px)</option>
                                                                                    <option value="24">Huge (24px)</option>
                                                                                </select>
                                                                            </div>



                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium rounded-lg transition-colors duration-200"
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
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">CSS Unit Conversion Results</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl border-l-4 border-indigo-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Em (em)</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Enter a value to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-indigo-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-indigo-600 hover:text-indigo-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- CSS Units Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Relative Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Relative Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Em</h5>
                                                                                            <div class="text-lg font-bold text-green-600 font-mono" id="emDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Relative to parent</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-lg border-l-4 border-emerald-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Rem</h5>
                                                                                            <div class="text-lg font-bold text-emerald-600 font-mono" id="remDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Relative to root</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-lg border-l-4 border-teal-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">%</h5>
                                                                                            <div class="text-lg font-bold text-teal-600 font-mono" id="percentDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Percentage</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Absolute Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Absolute Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Pixels</h5>
                                                                                            <div class="text-lg font-bold text-blue-600 font-mono" id="pixelsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Screen pixels</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Points</h5>
                                                                                            <div class="text-lg font-bold text-purple-600 font-mono" id="pointsDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Print points</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border-l-4 border-pink-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">Inches</h5>
                                                                                            <div class="text-lg font-bold text-pink-600 font-mono" id="inchesDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Physical inches</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Viewport Units -->
                                                                                <div class="space-y-3">
                                                                                    <h4 class="font-semibold text-gray-700 text-center">Viewport Units</h4>

                                                                                    <div class="p-3 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">VW</h5>
                                                                                            <div class="text-lg font-bold text-orange-600 font-mono" id="vwDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Viewport width</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-red-50 to-pink-50 rounded-lg border-l-4 border-red-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">VH</h5>
                                                                                            <div class="text-lg font-bold text-red-600 font-mono" id="vhDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Viewport height</div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="p-3 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                        <div class="text-center">
                                                                                            <h5 class="text-sm font-semibold text-gray-700 mb-1">VMIN</h5>
                                                                                            <div class="text-lg font-bold text-yellow-600 font-mono" id="vminDisplay">--</div>
                                                                                            <div class="text-xs text-gray-500 mt-1">Viewport minimum</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="hidden">
                                                                                <!-- CSS Code Generator -->
                                                                                <div class="p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg border border-gray-200">
                                                                                    <h4 class="text-sm font-semibold text-gray-800 mb-2 text-center">CSS Code Generator</h4>
                                                                                    <div class="bg-gray-900 text-green-400 p-4 rounded-lg font-mono text-sm overflow-x-auto" id="cssCode">
                                                                                        <span class="text-gray-500">/* Select conversion to generate CSS */</span>
                                                                                    </div>
                                                                                    <button class="mt-2 text-xs text-gray-600 hover:text-gray-800" id="copyCssCode">Copy CSS Code</button>
                                                                                </div>

                                                                                <!-- Responsive Breakpoints -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                                                                    <h4 class="text-sm font-semibold text-blue-800 mb-2 text-center">Responsive Breakpoints</h4>
                                                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Mobile:</span>
                                                                                            <span class="font-mono text-blue-700" id="mobileSize">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Tablet:</span>
                                                                                            <span class="font-mono text-blue-700" id="tabletSize">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Desktop:</span>
                                                                                            <span class="font-mono text-blue-700" id="desktopSize">--</span>
                                                                                        </div>
                                                                                        <div class="text-center">
                                                                                            <span class="text-gray-600 block">Large:</span>
                                                                                            <span class="font-mono text-blue-700" id="largeSize">--</span>
                                                                                        </div>
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
                <!-- Quick Examples -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-gray-700">
                                                            Quick CSS Examples
                                                        </label>
                                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="16" data-direction="px_to_em">16px</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="24" data-direction="px_to_em">24px</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="1.5" data-direction="em_to_px">1.5em</button>
                                                            <button type="button" class="example-btn px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="2" data-direction="rem_to_px">2rem</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Reference Information -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">CSS Unit Reference</h4>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-gray-600">
                                                        <div><strong>px</strong> = Pixels (absolute)</div>
                                                        <div><strong>em</strong> = Relative to parent font</div>
                                                        <div><strong>rem</strong> = Relative to root font</div>
                                                        <div><strong>%</strong> = Percentage of parent</div>
                                                        <div><strong>vw</strong> = Viewport width %</div>
                                                        <div><strong>vh</strong> = Viewport height %</div>
                                                        <div><strong>pt</strong> = Points (1/72 inch)</div>
                                                        <div><strong>in</strong> = Inches</div>
                                                        <div><strong>cm</strong> = Centimeters</div>
                                                        <div><strong>mm</strong> = Millimeters</div>
                                                        <div><strong>ch</strong> = Character width</div>
                                                        <div><strong>ex</strong> = X-height</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>


    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const conversionDirection = document.getElementById('conversionDirection');
                        const inputValue = document.getElementById('inputValue');
                        const baseFontSize = document.getElementById('baseFontSize');
                        const cssContext = document.getElementById('cssContext');
                        const browserPreset = document.getElementById('browserPreset');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Labels and hints
                        const inputLabel = document.getElementById('inputLabel');
                        const inputUnit = document.getElementById('inputUnit');
                        const inputHint = document.getElementById('inputHint');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const emDisplay = document.getElementById('emDisplay');
                        const remDisplay = document.getElementById('remDisplay');
                        const percentDisplay = document.getElementById('percentDisplay');
                        const pixelsDisplay = document.getElementById('pixelsDisplay');
                        const pointsDisplay = document.getElementById('pointsDisplay');
                        const inchesDisplay = document.getElementById('inchesDisplay');
                        const vwDisplay = document.getElementById('vwDisplay');
                        const vhDisplay = document.getElementById('vhDisplay');
                        const vminDisplay = document.getElementById('vminDisplay');
                        const cssCode = document.getElementById('cssCode');
                        const mobileSize = document.getElementById('mobileSize');
                        const tabletSize = document.getElementById('tabletSize');
                        const desktopSize = document.getElementById('desktopSize');
                        const largeSize = document.getElementById('largeSize');
                        const copyResult = document.getElementById('copyResult');
                        const copyCssCode = document.getElementById('copyCssCode');

                        function formatNumber(num, decimals = 3) {
                            if (num !== 0 && Math.abs(num) < Math.pow(10, -decimals)) {
                                return Number(num.toPrecision(3));
                            }

                            return parseFloat(num.toFixed(decimals));
                        }

                        const unitNames = {
                            px: 'Pixels (px)',
                            em: 'Em (em)',
                            rem: 'Rem (rem)'
                        };

                        function updateInputLabels() {
                            const direction = conversionDirection.value;
                            
                            switch(direction) {
                                case 'px_to_em':
                                    inputLabel.textContent = 'Pixel Value';
                                    inputUnit.textContent = 'px';
                                    inputHint.textContent = 'Enter pixel value for conversion to em';
                                    break;
                                case 'em_to_px':
                                    inputLabel.textContent = 'Em Value';
                                    inputUnit.textContent = 'em';
                                    inputHint.textContent = 'Enter em value for conversion to pixels';
                                    break;
                                case 'px_to_rem':
                                    inputLabel.textContent = 'Pixel Value';
                                    inputUnit.textContent = 'px';
                                    inputHint.textContent = 'Enter pixel value for conversion to rem';
                                    break;
                                case 'rem_to_px':
                                    inputLabel.textContent = 'Rem Value';
                                    inputUnit.textContent = 'rem';
                                    inputHint.textContent = 'Enter rem value for conversion to pixels';
                                    break;
                                case 'em_to_rem':
                                    inputLabel.textContent = 'Em Value';
                                    inputUnit.textContent = 'em';
                                    inputHint.textContent = 'Enter em value for conversion to rem';
                                    break;
                                case 'rem_to_em':
                                    inputLabel.textContent = 'Rem Value';
                                    inputUnit.textContent = 'rem';
                                    inputHint.textContent = 'Enter rem value for conversion to em';
                                    break;
                            }
                        }

                        function generateCssCode(context, value, unit) {
                            const property = context.replace('_', '-');
                            return `.element {\n  ${property}: ${value}${unit};\n}`;
                        }

                        function calculate() {
                            const direction = conversionDirection.value;
                            const value = parseFloat(inputValue.value);
                            const baseSize = parseFloat(baseFontSize.value) || 16;
                            const context = cssContext.value;
                            
                            if (!isNaN(value) && value >= 0) {
                                let pixels = 0;
                                let em = 0;
                                let rem = 0;
                                let primaryResult = '';
                                let primaryUnit = '';
                                
                                // Convert based on direction
                                switch(direction) {
                                    case 'px_to_em':
                                        pixels = value;
                                        em = value / baseSize;
                                        rem = value / baseSize;
                                        primaryResult = formatNumber(em);
                                        primaryUnit = 'em';
                                        break;
                                    case 'em_to_px':
                                        em = value;
                                        pixels = value * baseSize;
                                        rem = value; // em to rem is 1:1 if parent = root
                                        primaryResult = formatNumber(pixels);
                                        primaryUnit = 'px';
                                        break;
                                    case 'px_to_rem':
                                        pixels = value;
                                        rem = value / baseSize;
                                        em = value / baseSize;
                                        primaryResult = formatNumber(rem);
                                        primaryUnit = 'rem';
                                        break;
                                    case 'rem_to_px':
                                        rem = value;
                                        pixels = value * baseSize;
                                        em = value;
                                        primaryResult = formatNumber(pixels);
                                        primaryUnit = 'px';
                                        break;
                                    case 'em_to_rem':
                                        em = value;
                                        rem = value; // Assuming parent = root
                                        pixels = value * baseSize;
                                        primaryResult = formatNumber(rem);
                                        primaryUnit = 'rem';
                                        break;
                                    case 'rem_to_em':
                                        rem = value;
                                        em = value; // Assuming parent = root
                                        pixels = value * baseSize;
                                        primaryResult = formatNumber(em);
                                        primaryUnit = 'em';
                                        break;
                                }
                                
                                // Update primary output
                                output.textContent = primaryResult + primaryUnit;
                                resultTitle.textContent = unitNames[primaryUnit];
                                resultDescription.textContent = `${formatNumber(value)}${inputUnit.textContent} = ${primaryResult}${primaryUnit} (base font size ${formatNumber(baseSize)}px)`;

                                // Display all units
                                emDisplay.textContent = formatNumber(em) + 'em';
                                remDisplay.textContent = formatNumber(rem) + 'rem';
                                percentDisplay.textContent = formatNumber(em * 100) + '%';
                                pixelsDisplay.textContent = formatNumber(pixels) + 'px';
                                pointsDisplay.textContent = formatNumber(pixels * 0.75) + 'pt';
                                inchesDisplay.textContent = formatNumber(pixels / 96, 4) + 'in';
                                
                                // Viewport units (assuming 1920x1080 viewport)
                                vwDisplay.textContent = formatNumber(pixels / 19.2, 2) + 'vw';
                                vhDisplay.textContent = formatNumber(pixels / 10.8, 2) + 'vh';
                                vminDisplay.textContent = formatNumber(pixels / 10.8, 2) + 'vmin';

                                // Generate CSS code
                                cssCode.innerHTML = generateCssCode(context, primaryResult, primaryUnit);

                                // Responsive breakpoints (scale with base size)
                                const scale = baseSize / 16;
                                mobileSize.textContent = formatNumber(primaryResult * scale * 0.875, 2) + primaryUnit;
                                tabletSize.textContent = formatNumber(primaryResult * scale, 2) + primaryUnit;
                                desktopSize.textContent = formatNumber(primaryResult * scale * 1.125, 2) + primaryUnit;
                                largeSize.textContent = formatNumber(primaryResult * scale * 1.25, 2) + primaryUnit;

                            } else {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            resultTitle.textContent = unitNames[conversionDirection.value.split('_to_')[1]] || 'Converted Value';
                            resultDescription.textContent = 'Enter a value to convert';
                            emDisplay.textContent = '--';
                            remDisplay.textContent = '--';
                            percentDisplay.textContent = '--';
                            pixelsDisplay.textContent = '--';
                            pointsDisplay.textContent = '--';
                            inchesDisplay.textContent = '--';
                            vwDisplay.textContent = '--';
                            vhDisplay.textContent = '--';
                            vminDisplay.textContent = '--';
                            cssCode.innerHTML = '<span class="text-gray-500">/* Select conversion to generate CSS */</span>';
                            mobileSize.textContent = '--';
                            tabletSize.textContent = '--';
                            desktopSize.textContent = '--';
                            largeSize.textContent = '--';
                        }

                        function clearAll() {
                            inputValue.value = '';
                            conversionDirection.value = 'px_to_em';
                            baseFontSize.value = '16';
                            cssContext.value = 'font_size';
                            browserPreset.value = '16';
                            updateInputLabels();
                            clearOutputs();
                            inputValue.focus();
                        }

                        // Event listeners
                        conversionDirection.addEventListener('change', function() {
                            updateInputLabels();
                            calculate();
                        });
                        
                        inputValue.addEventListener('input', calculate);
                        baseFontSize.addEventListener('input', calculate);
                        cssContext.addEventListener('change', calculate);
                        
                        browserPreset.addEventListener('change', function() {
                            baseFontSize.value = this.value;
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

                        copyCssCode.addEventListener('click', function() {
                            const text = cssCode.textContent;
                            if (!text.includes('Select conversion')) {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy CSS Code';
                                    }, 2000);
                                });
                            }
                        });

                        // Example buttons
                        const exampleBtns = document.querySelectorAll('.example-btn');
                        exampleBtns.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const direction = this.getAttribute('data-direction');
                                
                                inputValue.value = value;
                                conversionDirection.value = direction;
                                updateInputLabels();
                                calculate();
                                
                                // Update button styles
                                exampleBtns.forEach(btn => btn.classList.remove('bg-indigo-100', 'text-indigo-700'));
                                exampleBtns.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-indigo-100', 'text-indigo-700');
                            });
                        });

                        // Clickable examples
                        const examples = document.querySelectorAll('[data-value][data-direction]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const direction = this.getAttribute('data-direction');
                                
                                if (value && direction) {
                                    inputValue.value = value;
                                    conversionDirection.value = direction;
                                    updateInputLabels();
                                    calculate();
                                    inputValue.focus();
                                }
                            });
                        });

                        // Initialize
                        updateInputLabels();
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
