<x-tool-page-layout
    title="Scale Calculator - ConvertPro"
    description="Professional scale calculator for maps, drawings and models. Calculate map scales, ratios and convert between different scale representations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">Scale Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Calculation Mode -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Calculation Mode
                                                                                </label>
                                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer bg-cyan-50 border-cyan-300">
                                                                                        <input type="radio" name="mode" value="find-scale" class="text-cyan-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Find Scale</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="find-real" class="text-cyan-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Find Real Distance</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="find-map" class="text-cyan-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Find Map Distance</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Fields (Dynamic based on mode) -->
                                                                            <div id="inputFields">

                                                                                <!-- Find Scale Mode -->
                                                                                <div id="findScaleInputs" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                    <div class="space-y-2">
                                                                                        <label for="mapDistance" class="block text-sm font-semibold text-gray-700">Map Distance</label>
                                                                                        <div class="grid grid-cols-[minmax(0,1fr)_auto]">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="mapDistance" 
                                                                                                class="min-w-0 px-4 py-3 border-2 border-gray-200 rounded-l-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 5"
                                                                                                step="any"
                                                                                                min="0"
                                                                                            >
                                                                                            <select 
                                                                                                id="mapUnit" 
                                                                                                class="w-24 px-3 py-3 border-2 border-l-0 border-gray-200 rounded-r-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 bg-white"
                                                                                            >
                                                                                                <option value="mm">mm</option>
                                                                                                <option value="cm" selected>cm</option>
                                                                                                <option value="in">inches</option>
                                                                                                <option value="ft">feet</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="space-y-2">
                                                                                        <label for="realDistance" class="block text-sm font-semibold text-gray-700">Real Distance</label>
                                                                                        <div class="grid grid-cols-[minmax(0,1fr)_auto]">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="realDistance" 
                                                                                                class="min-w-0 px-4 py-3 border-2 border-gray-200 rounded-l-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 500"
                                                                                                step="any"
                                                                                                min="0"
                                                                                            >
                                                                                            <select 
                                                                                                id="realUnit" 
                                                                                                class="w-24 px-3 py-3 border-2 border-l-0 border-gray-200 rounded-r-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 bg-white"
                                                                                            >
                                                                                                <option value="mm">mm</option>
                                                                                                <option value="cm">cm</option>
                                                                                                <option value="m" selected>meters</option>
                                                                                                <option value="km">km</option>
                                                                                                <option value="in">inches</option>
                                                                                                <option value="ft">feet</option>
                                                                                                <option value="yd">yards</option>
                                                                                                <option value="mi">miles</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Find Real Distance Mode -->
                                                                                <div id="findRealInputs" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
                                                                                    <div class="space-y-2">
                                                                                        <label for="mapDistance2" class="block text-sm font-semibold text-gray-700">Map Distance</label>
                                                                                        <div class="grid grid-cols-[minmax(0,1fr)_auto]">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="mapDistance2" 
                                                                                                class="min-w-0 px-4 py-3 border-2 border-gray-200 rounded-l-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 5"
                                                                                                step="any"
                                                                                                min="0"
                                                                                            >
                                                                                            <select 
                                                                                                id="mapUnit2" 
                                                                                                class="w-24 px-3 py-3 border-2 border-l-0 border-gray-200 rounded-r-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 bg-white"
                                                                                            >
                                                                                                <option value="mm">mm</option>
                                                                                                <option value="cm" selected>cm</option>
                                                                                                <option value="in">inches</option>
                                                                                                <option value="ft">feet</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="space-y-2">
                                                                                        <label for="scaleRatio" class="block text-sm font-semibold text-gray-700">Scale (1:x)</label>
                                                                                        <div class="relative">
                                                                                            <span class="absolute left-3 top-3 text-gray-500 font-medium">1:</span>
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="scaleRatio" 
                                                                                                class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 100000"
                                                                                                step="any"
                                                                                                min="1"
                                                                                            >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Find Map Distance Mode -->
                                                                                <div id="findMapInputs" class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
                                                                                    <div class="space-y-2">
                                                                                        <label for="realDistance2" class="block text-sm font-semibold text-gray-700">Real Distance</label>
                                                                                        <div class="grid grid-cols-[minmax(0,1fr)_auto]">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="realDistance2" 
                                                                                                class="min-w-0 px-4 py-3 border-2 border-gray-200 rounded-l-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 500"
                                                                                                step="any"
                                                                                                min="0"
                                                                                            >
                                                                                            <select 
                                                                                                id="realUnit2" 
                                                                                                class="w-24 px-3 py-3 border-2 border-l-0 border-gray-200 rounded-r-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 bg-white"
                                                                                            >
                                                                                                <option value="mm">mm</option>
                                                                                                <option value="cm">cm</option>
                                                                                                <option value="m" selected>meters</option>
                                                                                                <option value="km">km</option>
                                                                                                <option value="in">inches</option>
                                                                                                <option value="ft">feet</option>
                                                                                                <option value="yd">yards</option>
                                                                                                <option value="mi">miles</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="space-y-2">
                                                                                        <label for="scaleRatio2" class="block text-sm font-semibold text-gray-700">Scale (1:x)</label>
                                                                                        <div class="relative">
                                                                                            <span class="absolute left-3 top-3 text-gray-500 font-medium">1:</span>
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="scaleRatio2" 
                                                                                                class="w-full pl-8 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="e.g., 100000"
                                                                                                step="any"
                                                                                                min="1"
                                                                                            >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <!-- Common Map Scales -->
                                                                            

                                                                            <!-- Precision Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Result Precision
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="0" class="text-cyan-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Whole</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-cyan-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-cyan-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-cyan-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-cyan-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Clear Button -->
                                                                            <div class="flex justify-center">
                                                                                <button 
                                                                                    type="button" 
                                                                                    id="clearButton"
                                                                                    class="inline-flex items-center px-4 py-2 bg-cyan-100 hover:bg-cyan-200 text-cyan-700 font-medium rounded-lg transition-colors duration-200"
                                                                                >
                                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                                    </svg>
                                                                                    Clear All
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-7">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-gray-800 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="p-6 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-xl border-l-4 border-cyan-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Calculated Scale</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Map scale ratio</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-cyan-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-cyan-600 hover:text-cyan-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Scale Representations -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Ratio Scale -->
                                                                                <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-l-4 border-blue-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Representative Fraction</h4>
                                                                                        <div class="text-lg font-bold text-blue-600 font-mono" id="ratioScale">--</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Verbal Scale -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Verbal Scale</h4>
                                                                                        <div class="text-sm font-bold text-green-600" id="verbalScale">--</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Scale Factor -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Scale Factor</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="scaleFactor">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Distance Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Map Distance -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Map Distance</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="mapDistanceResult">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Distance on map/drawing</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Real Distance -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Real Distance</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="realDistanceResult">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Actual distance in reality</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Scale Information -->
                                                                            <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-200">
                                                                                <h4 class="text-sm font-semibold text-indigo-800 mb-2 text-center">Scale Information</h4>
                                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">Scale Type:</span>
                                                                                        <span class="font-mono text-indigo-700" id="scaleType">--</span>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">Reduction Factor:</span>
                                                                                        <span class="font-mono text-indigo-700" id="reductionFactor">--</span>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">1 cm represents:</span>
                                                                                        <span class="font-mono text-indigo-700" id="cmRepresents">--</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Visual Scale Bar -->
                                                                            <div class="p-4 bg-gradient-to-r from-gray-50 to-slate-50 rounded-lg border border-gray-200">
                                                                                <h4 class="text-sm font-semibold text-gray-700 mb-3 text-center">Visual Scale Bar</h4>
                                                                                <div class="flex items-center justify-center">
                                                                                    <div class="bg-white border-2 border-gray-300 rounded-lg p-4 w-full max-w-md">
                                                                                        <div class="flex items-center justify-between mb-2">
                                                                                            <span class="text-xs text-gray-600">0</span>
                                                                                            <span class="text-xs text-gray-600" id="scaleBarLabel">--</span>
                                                                                        </div>
                                                                                        <div class="w-full h-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded relative">
                                                                                            <div class="absolute inset-0 bg-white bg-opacity-20 rounded"></div>
                                                                                            <div class="absolute left-0 top-0 w-1 h-full bg-white"></div>
                                                                                            <div class="absolute left-1/4 top-0 w-1 h-full bg-white opacity-60"></div>
                                                                                            <div class="absolute left-1/2 top-0 w-1 h-full bg-white"></div>
                                                                                            <div class="absolute left-3/4 top-0 w-1 h-full bg-white opacity-60"></div>
                                                                                            <div class="absolute right-0 top-0 w-1 h-full bg-white"></div>
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
                <div class="space-y-2">
                                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                                    Common Map Scales
                                                                                                </label>
                                                                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                                                                    <button type="button" class="scale-preset px-3 py-2 text-sm bg-gray-100 hover:bg-cyan-100 text-gray-700 hover:text-cyan-700 rounded-lg transition-colors" data-scale="25000">1:25,000</button>
                                                                                                    <button type="button" class="scale-preset px-3 py-2 text-sm bg-gray-100 hover:bg-cyan-100 text-gray-700 hover:text-cyan-700 rounded-lg transition-colors" data-scale="50000">1:50,000</button>
                                                                                                    <button type="button" class="scale-preset px-3 py-2 text-sm bg-gray-100 hover:bg-cyan-100 text-gray-700 hover:text-cyan-700 rounded-lg transition-colors" data-scale="100000">1:100,000</button>
                                                                                                    <button type="button" class="scale-preset px-3 py-2 text-sm bg-gray-100 hover:bg-cyan-100 text-gray-700 hover:text-cyan-700 rounded-lg transition-colors" data-scale="250000">1:250,000</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Scale Reference Guide</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• Large Scale: 1:25,000 or larger (more detail)</div>
                                                        <div>• Medium Scale: 1:25,000 to 1:250,000</div>
                                                        <div>• Small Scale: 1:250,000 or smaller (less detail)</div>
                                                        <div>• Scale = Map Distance ÷ Real Distance</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About Scale Calculations</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Map & Drawing Scales</h4>
                                    <p>Scale represents the ratio between distances on a map or drawing and the corresponding distances in reality. Essential for cartography, architecture, engineering drawings, and model making.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Professional Applications</h4>
                                    <p>Used in surveying, urban planning, architectural drawings, engineering blueprints, and geographic information systems (GIS). Accurate scale calculations ensure proper representation and measurement.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-cyan-50 rounded-lg border border-cyan-200">
                                <p class="text-sm text-cyan-800">
                                    <strong>Scale Tip:</strong> Larger scale numbers (1:1,000) show more detail but cover smaller areas. Smaller scale numbers (1:1,000,000) show less detail but cover larger areas!
                                </p>
                            </div>
                        </div>

                        <!-- Common Scale Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Scale Examples</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">Architectural Scales</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="text-center p-2 bg-gray-50 rounded">
                                            <div class="font-medium text-cyan-600 cursor-pointer hover:text-cyan-800" data-scale-example="48">1:48</div>
                                            <div class="text-xs text-gray-500">1/4" = 1'</div>
                                        </div>
                                        <div class="text-center p-2 bg-gray-50 rounded">
                                            <div class="font-medium text-cyan-600 cursor-pointer hover:text-cyan-800" data-scale-example="96">1:96</div>
                                            <div class="text-xs text-gray-500">1/8" = 1'</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">Topographic Maps</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="text-center p-2 bg-gray-50 rounded">
                                            <div class="font-medium text-cyan-600 cursor-pointer hover:text-cyan-800" data-scale-example="24000">1:24,000</div>
                                            <div class="text-xs text-gray-500">USGS Quad</div>
                                        </div>
                                        <div class="text-center p-2 bg-gray-50 rounded">
                                            <div class="font-medium text-cyan-600 cursor-pointer hover:text-cyan-800" data-scale-example="100000">1:100,000</div>
                                            <div class="text-xs text-gray-500">Regional Map</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Input elements for different modes
                        const mapDistance = document.getElementById('mapDistance');
                        const realDistance = document.getElementById('realDistance');
                        const mapUnit = document.getElementById('mapUnit');
                        const realUnit = document.getElementById('realUnit');
                        
                        const mapDistance2 = document.getElementById('mapDistance2');
                        const scaleRatio = document.getElementById('scaleRatio');
                        const mapUnit2 = document.getElementById('mapUnit2');
                        
                        const realDistance2 = document.getElementById('realDistance2');
                        const scaleRatio2 = document.getElementById('scaleRatio2');
                        const realUnit2 = document.getElementById('realUnit2');
                        
                        const modeRadios = document.getElementsByName('mode');
                        const precisionRadios = document.getElementsByName('precision');
                        const clearButton = document.getElementById('clearButton');
                        
                        // Input containers
                        const findScaleInputs = document.getElementById('findScaleInputs');
                        const findRealInputs = document.getElementById('findRealInputs');
                        const findMapInputs = document.getElementById('findMapInputs');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const ratioScale = document.getElementById('ratioScale');
                        const verbalScale = document.getElementById('verbalScale');
                        const scaleFactor = document.getElementById('scaleFactor');
                        const mapDistanceResult = document.getElementById('mapDistanceResult');
                        const realDistanceResult = document.getElementById('realDistanceResult');
                        const scaleType = document.getElementById('scaleType');
                        const reductionFactor = document.getElementById('reductionFactor');
                        const cmRepresents = document.getElementById('cmRepresents');
                        const scaleBarLabel = document.getElementById('scaleBarLabel');
                        const copyResult = document.getElementById('copyResult');

                        // Unit conversion factors to meters
                        const unitToMeters = {
                            mm: 0.001,
                            cm: 0.01,
                            m: 1,
                            km: 1000,
                            in: 0.0254,
                            ft: 0.3048,
                            yd: 0.9144,
                            mi: 1609.344
                        };

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'auto') {
                                if (num >= 1000000) {
                                    return Number(num.toPrecision(3)).toExponential();
                                } else if (num >= 1000) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 1 });
                                } else if (num >= 1) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                                } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                    return Number(num.toPrecision(4)).toExponential();
                                } else {
                                    return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                                }
                            } else {
                                if (num !== 0 && Math.abs(num) < 0.5 * Math.pow(10, -precision)) {
                                    return Math.abs(num) < 0.000001 ? Number(num.toPrecision(4)).toExponential() : num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                                }
                                return num.toLocaleString(undefined, { maximumFractionDigits: precision });
                            }
                        }

                        function convertToMeters(value, unit) {
                            return value * unitToMeters[unit];
                        }

                        function convertFromMeters(value, unit) {
                            return value / unitToMeters[unit];
                        }

                        function getScaleType(scale) {
                            if (scale <= 5000) return 'Very Large Scale';
                            if (scale <= 25000) return 'Large Scale';
                            if (scale <= 250000) return 'Medium Scale';
                            if (scale <= 1000000) return 'Small Scale';
                            return 'Very Small Scale';
                        }

                        function generateVerbalScale(scale) {
                            const kmPerCm = scale * 0.00001;
                            const mPerCm = scale * 0.01;
                            
                            if (kmPerCm >= 1) {
                                return `1 cm = ${formatNumber(kmPerCm, 2)} km`;
                            } else if (mPerCm >= 1) {
                                return `1 cm = ${formatNumber(mPerCm, 1)} m`;
                            } else {
                                return `1 cm = ${formatNumber(mPerCm * 100, 1)} cm`;
                            }
                        }

                        function updateInterface() {
                            const mode = getMode();
                            
                            // Hide all input containers
                            findScaleInputs.style.display = 'none';
                            findRealInputs.style.display = 'none';
                            findMapInputs.style.display = 'none';
                            
                            // Show appropriate container and update labels
                            switch(mode) {
                                case 'find-scale':
                                    findScaleInputs.style.display = 'grid';
                                    resultTitle.textContent = 'Calculated Scale';
                                    resultDescription.textContent = 'Representative fraction';
                                    break;
                                case 'find-real':
                                    findRealInputs.style.display = 'grid';
                                    resultTitle.textContent = 'Real Distance';
                                    resultDescription.textContent = 'Actual distance in reality';
                                    break;
                                case 'find-map':
                                    findMapInputs.style.display = 'grid';
                                    resultTitle.textContent = 'Map Distance';
                                    resultDescription.textContent = 'Distance on map/drawing';
                                    break;
                            }
                        }

                        function calculate() {
                            const mode = getMode();
                            const precision = getPrecision();
                            let scale, mapDist, realDist;

                            try {
                                switch(mode) {
                                    case 'find-scale':
                                        const mapVal = parseFloat(mapDistance.value);
                                        const realVal = parseFloat(realDistance.value);
                                        
                                        if (!isNaN(mapVal) && !isNaN(realVal) && mapVal > 0 && realVal > 0) {
                                            const mapInMeters = convertToMeters(mapVal, mapUnit.value);
                                            const realInMeters = convertToMeters(realVal, realUnit.value);
                                            scale = realInMeters / mapInMeters;
                                            mapDist = mapVal;
                                            realDist = realVal;
                                            
                                            output.textContent = `1:${formatNumber(scale, 0)}`;
                                        } else {
                                            clearOutputs();
                                            return;
                                        }
                                        break;
                                        
                                    case 'find-real':
                                        const mapVal2 = parseFloat(mapDistance2.value);
                                        const scaleVal = parseFloat(scaleRatio.value);
                                        
                                        if (!isNaN(mapVal2) && !isNaN(scaleVal) && mapVal2 > 0 && scaleVal > 0) {
                                            scale = scaleVal;
                                            const mapInMeters = convertToMeters(mapVal2, mapUnit2.value);
                                            const realInMeters = mapInMeters * scale;
                                            
                                            // Convert to appropriate unit for display
                                            let displayUnit, displayValue;
                                            if (realInMeters >= 1000) {
                                                displayUnit = 'km';
                                                displayValue = realInMeters / 1000;
                                            } else if (realInMeters >= 1) {
                                                displayUnit = 'm';
                                                displayValue = realInMeters;
                                            } else {
                                                displayUnit = 'cm';
                                                displayValue = realInMeters * 100;
                                            }
                                            
                                            output.textContent = `${formatNumber(displayValue, precision)} ${displayUnit}`;
                                            mapDist = mapVal2;
                                            realDist = displayValue;
                                        } else {
                                            clearOutputs();
                                            return;
                                        }
                                        break;
                                        
                                    case 'find-map':
                                        const realVal2 = parseFloat(realDistance2.value);
                                        const scaleVal2 = parseFloat(scaleRatio2.value);
                                        
                                        if (!isNaN(realVal2) && !isNaN(scaleVal2) && realVal2 > 0 && scaleVal2 > 0) {
                                            scale = scaleVal2;
                                            const realInMeters = convertToMeters(realVal2, realUnit2.value);
                                            const mapInMeters = realInMeters / scale;
                                            
                                            // Convert to appropriate unit for display
                                            let displayUnit, displayValue;
                                            if (mapInMeters >= 1) {
                                                displayUnit = 'm';
                                                displayValue = mapInMeters;
                                            } else if (mapInMeters >= 0.01) {
                                                displayUnit = 'cm';
                                                displayValue = mapInMeters * 100;
                                            } else {
                                                displayUnit = 'mm';
                                                displayValue = mapInMeters * 1000;
                                            }
                                            
                                            output.textContent = `${formatNumber(displayValue, precision)} ${displayUnit}`;
                                            mapDist = displayValue;
                                            realDist = realVal2;
                                        } else {
                                            clearOutputs();
                                            return;
                                        }
                                        break;
                                }

                                // Update all scale representations
                                ratioScale.textContent = `1:${formatNumber(scale, 0)}`;
                                verbalScale.textContent = generateVerbalScale(scale);
                                scaleFactor.textContent = formatNumber(1/scale, precision);
                                
                                // Update distance displays
                                if (mode === 'find-scale') {
                                    mapDistanceResult.textContent = `${formatNumber(mapDist, precision)} ${mapUnit.value}`;
                                    realDistanceResult.textContent = `${formatNumber(realDist, precision)} ${realUnit.value}`;
                                } else if (mode === 'find-real') {
                                    mapDistanceResult.textContent = `${formatNumber(mapDist, precision)} ${mapUnit2.value}`;
                                    realDistanceResult.textContent = output.textContent;
                                } else {
                                    mapDistanceResult.textContent = output.textContent;
                                    realDistanceResult.textContent = `${formatNumber(realDist, precision)} ${realUnit2.value}`;
                                }
                                
                                // Update scale information
                                scaleType.textContent = getScaleType(scale);
                                reductionFactor.textContent = `${formatNumber(scale, 0)}x smaller`;
                                cmRepresents.textContent = generateVerbalScale(scale).split(' = ')[1];
                                
                                // Update scale bar
                                const barDistance = scale * 0.01; // 1 cm on scale bar
                                if (barDistance >= 1000) {
                                    scaleBarLabel.textContent = `${formatNumber(barDistance/1000, 1)} km`;
                                } else if (barDistance >= 1) {
                                    scaleBarLabel.textContent = `${formatNumber(barDistance, 0)} m`;
                                } else {
                                    scaleBarLabel.textContent = `${formatNumber(barDistance*100, 0)} cm`;
                                }

                            } catch (error) {
                                clearOutputs();
                            }
                        }

                        function clearOutputs() {
                            output.textContent = '--';
                            ratioScale.textContent = '--';
                            verbalScale.textContent = '--';
                            scaleFactor.textContent = '--';
                            mapDistanceResult.textContent = '--';
                            realDistanceResult.textContent = '--';
                            scaleType.textContent = '--';
                            reductionFactor.textContent = '--';
                            cmRepresents.textContent = '--';
                            scaleBarLabel.textContent = '--';
                        }

                        function clearAll() {
                            mapDistance.value = '';
                            realDistance.value = '';
                            mapDistance2.value = '';
                            scaleRatio.value = '';
                            realDistance2.value = '';
                            scaleRatio2.value = '';
                            clearOutputs();
                            
                            const mode = getMode();
                            if (mode === 'find-scale') {
                                mapDistance.focus();
                            } else if (mode === 'find-real') {
                                mapDistance2.focus();
                            } else {
                                realDistance2.focus();
                            }
                        }

                        // Event listeners
                        mapDistance.addEventListener('input', calculate);
                        realDistance.addEventListener('input', calculate);
                        mapUnit.addEventListener('change', calculate);
                        realUnit.addEventListener('change', calculate);
                        
                        mapDistance2.addEventListener('input', calculate);
                        scaleRatio.addEventListener('input', calculate);
                        mapUnit2.addEventListener('change', calculate);
                        
                        realDistance2.addEventListener('input', calculate);
                        scaleRatio2.addEventListener('input', calculate);
                        realUnit2.addEventListener('change', calculate);
                        
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                calculate();
                            });
                        });

                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', calculate);
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

                        // Scale preset buttons
                        const scalePresets = document.querySelectorAll('.scale-preset');
                        scalePresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const scale = this.getAttribute('data-scale');
                                
                                if (getMode() === 'find-real') {
                                    scaleRatio.value = scale;
                                } else if (getMode() === 'find-map') {
                                    scaleRatio2.value = scale;
                                }
                                calculate();
                                
                                // Update button styles
                                scalePresets.forEach(btn => btn.classList.remove('bg-cyan-100', 'text-cyan-700'));
                                scalePresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-cyan-100', 'text-cyan-700');
                            });
                        });

                        // Scale example buttons
                        const scaleExamples = document.querySelectorAll('[data-scale-example]');
                        scaleExamples.forEach(element => {
                            element.addEventListener('click', function() {
                                const scale = this.getAttribute('data-scale-example');
                                
                                if (getMode() === 'find-real') {
                                    scaleRatio.value = scale;
                                } else if (getMode() === 'find-map') {
                                    scaleRatio2.value = scale;
                                }
                                calculate();
                            });
                        });

                        // Initialize
                        updateInterface();
                        mapDistance.focus();
                        calculate();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
