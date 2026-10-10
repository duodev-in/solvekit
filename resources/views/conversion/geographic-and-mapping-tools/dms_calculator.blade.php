<x-tool-page-layout
    title="Degrees Minutes Seconds Calculator - ConvertPro"
    description="Professional DMS calculator for navigation, surveying and astronomy. Convert between decimal degrees and degrees minutes seconds format with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-visible">
                            
                            <!-- Calculator Header -->
                            <div class="border-b border-slate-200 bg-slate-900 px-5 py-3">
                                <h1 class="text-lg font-semibold text-white">DMS Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="p-5 sm:p-6">
                                
                                <div class="grid gap-6 lg:grid-cols-12">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm focus-within:ring-2 focus-within:ring-slate-200 lg:sticky lg:top-24 lg:z-20 lg:max-h-[calc(100vh-7.5rem)] lg:overflow-y-auto" id="calculatorForm">

                                                                            <!-- Conversion Mode -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Conversion Mode
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer bg-blue-50 border-blue-300">
                                                                                        <input type="radio" name="mode" value="dd-to-dms" class="text-blue-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">DD → DMS</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="mode" value="dms-to-dd" class="text-blue-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">DMS → DD</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Decimal Degrees Input -->
                                                                            <div id="ddInput" class="space-y-2">
                                                                                <label for="decimalDegrees" class="block text-sm font-semibold text-gray-700">
                                                                                    Decimal Degrees
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="decimalDegrees" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter decimal degrees (e.g., 40.7589)"
                                                                                        step="any"
                                                                                        min="-360"
                                                                                        max="360"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">°</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-xs text-gray-500">Range: -360° to +360°</p>
                                                                            </div>

                                                                            <!-- DMS Input -->
                                                                            <div id="dmsInput" class="space-y-4" style="display: none;">
                                                                                <div class="grid grid-cols-3 gap-4">
                                                                                    <div class="space-y-2">
                                                                                        <label for="degrees" class="block text-sm font-semibold text-gray-700">Degrees</label>
                                                                                        <div class="relative">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="degrees" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="40"
                                                                                                min="0"
                                                                                                max="360"
                                                                                            >
                                                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                                <span class="text-gray-500 text-sm font-medium">°</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="space-y-2">
                                                                                        <label for="minutes" class="block text-sm font-semibold text-gray-700">Minutes</label>
                                                                                        <div class="relative">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="minutes" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="45"
                                                                                                min="0"
                                                                                                max="59"
                                                                                            >
                                                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                                <span class="text-gray-500 text-sm font-medium">'</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="space-y-2">
                                                                                        <label for="seconds" class="block text-sm font-semibold text-gray-700">Seconds</label>
                                                                                        <div class="relative">
                                                                                            <input 
                                                                                                type="number" 
                                                                                                id="seconds" 
                                                                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                                placeholder="32.04"
                                                                                                min="0"
                                                                                                max="59.999"
                                                                                                step="any"
                                                                                            >
                                                                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                                <span class="text-gray-500 text-sm font-medium">"</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Direction -->
                                                                                <div class="space-y-2">
                                                                                    <label class="block text-sm font-semibold text-gray-700">Direction (for coordinates)</label>
                                                                                    <div class="grid grid-cols-4 gap-2">
                                                                                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                            <input type="radio" name="direction" value="positive" class="text-blue-600 focus:ring-slate-200" checked>
                                                                                            <span class="text-sm font-medium">Positive</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                            <input type="radio" name="direction" value="negative" class="text-blue-600 focus:ring-slate-200">
                                                                                            <span class="text-sm font-medium">Negative</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                            <input type="radio" name="direction" value="N" class="text-blue-600 focus:ring-slate-200">
                                                                                            <span class="text-sm font-medium">North</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                            <input type="radio" name="direction" value="S" class="text-blue-600 focus:ring-slate-200">
                                                                                            <span class="text-sm font-medium">South</span>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="grid grid-cols-4 gap-2 mt-2">
                                                                                        <div></div>
                                                                                        <div></div>
                                                                                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                            <input type="radio" name="direction" value="E" class="text-blue-600 focus:ring-slate-200">
                                                                                            <span class="text-sm font-medium">East</span>
                                                                                        </label>
                                                                                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                            <input type="radio" name="direction" value="W" class="text-blue-600 focus:ring-slate-200">
                                                                                            <span class="text-sm font-medium">West</span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Input Format Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Angle Context
                                                                                </label>
                                                                                <div class="grid grid-cols-3 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="context" value="general" class="text-blue-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">General Angle</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="context" value="latitude" class="text-blue-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Latitude</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="context" value="longitude" class="text-blue-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Longitude</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Precision Level -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-gray-700">
                                                                                    Precision Level
                                                                                </label>
                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="2" class="text-blue-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">2 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="4" class="text-blue-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">4 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-blue-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="auto" class="text-blue-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">Auto</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Sample Values -->
                                                                            

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
                                                                            <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-l-4 border-blue-500">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-1" id="result-title">Converted Angle</h4>
                                                                                        <p class="text-sm text-gray-600" id="result-description">Target angle format</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="text-2xl font-bold text-blue-600 font-mono" id="output">--</div>
                                                                                        <button class="text-xs text-blue-600 hover:text-blue-800 mt-1" id="copyResult">Copy Result</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Dual Display -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <!-- Decimal Degrees -->
                                                                                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg border-l-4 border-green-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Decimal Degrees</h4>
                                                                                        <div class="text-lg font-bold text-green-600 font-mono" id="ddDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">DD format</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- DMS Format -->
                                                                                <div class="p-4 bg-gradient-to-r from-purple-50 to-violet-50 rounded-lg border-l-4 border-purple-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">DMS Format</h4>
                                                                                        <div class="text-lg font-bold text-purple-600 font-mono" id="dmsDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Degrees Minutes Seconds</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Angle Formats -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <!-- Radians -->
                                                                                <div class="p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-lg border-l-4 border-orange-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Radians</h4>
                                                                                        <div class="text-lg font-bold text-orange-600 font-mono" id="radiansDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Mathematical unit</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Gradians -->
                                                                                <div class="p-4 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-lg border-l-4 border-cyan-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Gradians</h4>
                                                                                        <div class="text-lg font-bold text-cyan-600 font-mono" id="gradiansDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Centesimal degrees</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Mils -->
                                                                                <div class="p-4 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-lg border-l-4 border-yellow-500">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Mils</h4>
                                                                                        <div class="text-lg font-bold text-yellow-600 font-mono" id="milsDisplay">--</div>
                                                                                        <div class="text-xs text-gray-500 mt-1">Military unit</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Angle Analysis -->
                                                                            <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg border border-indigo-200">
                                                                                <h4 class="text-sm font-semibold text-indigo-800 mb-2 text-center">Angle Analysis</h4>
                                                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">Quadrant:</span>
                                                                                        <span class="font-mono text-indigo-700" id="quadrant">--</span>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">Type:</span>
                                                                                        <span class="font-mono text-indigo-700" id="angleType">--</span>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">Reference:</span>
                                                                                        <span class="font-mono text-indigo-700" id="referenceAngle">--</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Coordinate Context Display -->
                                                                            <div class="p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-lg border border-pink-200" id="coordinateContext" style="display: none;">
                                                                                <h4 class="text-sm font-semibold text-pink-800 mb-2 text-center">Coordinate Context</h4>
                                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">Context:</span>
                                                                                        <span class="font-mono text-pink-700" id="contextType">--</span>
                                                                                    </div>
                                                                                    <div class="text-center">
                                                                                        <span class="text-gray-600 block">Valid Range:</span>
                                                                                        <span class="font-mono text-pink-700" id="validRange">--</span>
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
                                                                                                    Sample Angle Values
                                                                                                </label>
                                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                                    <button type="button" class="sample-value px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="30">30°</button>
                                                                                                    <button type="button" class="sample-value px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="45.5">45.5°</button>
                                                                                                    <button type="button" class="sample-value px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="90">90°</button>
                                                                                                    <button type="button" class="sample-value px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="180">180°</button>
                                                                                                </div>
                                                                                                <div class="grid grid-cols-4 gap-2 mt-2">
                                                                                                    <button type="button" class="sample-value px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="40.7589">NYC Lat</button>
                                                                                                    <button type="button" class="sample-value px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="-73.9851">NYC Lng</button>
                                                                                                    <button type="button" class="sample-value px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="51.5074">London Lat</button>
                                                                                                    <button type="button" class="sample-value px-3 py-2 text-sm bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors" data-value="139.6503">Tokyo Lng</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Angular Measurement Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                                        <div>• 1° = 60' (60 minutes)</div>
                                                        <div>• 1' = 60" (60 seconds)</div>
                                                        <div>• 1° = 3600" (3600 seconds)</div>
                                                        <div>• 1 radian = 57.2958°</div>
                                                        <div>• 1 gradian = 0.9°</div>
                                                        <div>• 1 mil = 0.05625°</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">About DMS Calculations</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-sm text-gray-600">
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Navigation & Surveying</h4>
                                    <p>DMS format is essential in navigation, surveying, astronomy, and cartography. It provides more intuitive representation of angular measurements and is widely used in GPS coordinates and maritime navigation.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-700 mb-2">Precision Applications</h4>
                                    <p>Critical for high-precision measurements in surveying, telescope positioning, satellite tracking, and any application requiring exact angular positioning. The sexagesimal system allows for very precise angle specifications.</p>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <p class="text-sm text-blue-800">
                                    <strong>Navigation Tip:</strong> DMS format is commonly used in marine and aviation charts. One second of latitude equals approximately 31 meters (102 feet) on Earth's surface!
                                </p>
                            </div>
                        </div>

                        <!-- Angle Examples -->
                        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Common Angle Examples</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">Geographic Coordinates</h4>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-blue-600 cursor-pointer hover:text-blue-800" data-sample="40.7589">New York Latitude: 40.7589°</div>
                                        <div class="text-xs text-gray-600 mt-1">= 40°45'32.04"N</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-blue-600 cursor-pointer hover:text-blue-800" data-sample="-73.9851">New York Longitude: -73.9851°</div>
                                        <div class="text-xs text-gray-600 mt-1">= 73°59'6.36"W</div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <h4 class="font-semibold text-gray-700">Common Angles</h4>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-blue-600 cursor-pointer hover:text-blue-800" data-sample="45">Right triangle: 45°</div>
                                        <div class="text-xs text-gray-600 mt-1">= 45°0'0" = π/4 radians</div>
                                    </div>
                                    <div class="p-3 bg-gray-50 rounded-lg">
                                        <div class="font-medium text-blue-600 cursor-pointer hover:text-blue-800" data-sample="90">Right angle: 90°</div>
                                        <div class="text-xs text-gray-600 mt-1">= 90°0'0" = π/2 radians</div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const decimalDegrees = document.getElementById('decimalDegrees');
                        const degrees = document.getElementById('degrees');
                        const minutes = document.getElementById('minutes');
                        const seconds = document.getElementById('seconds');
                        const modeRadios = document.getElementsByName('mode');
                        const directionRadios = document.getElementsByName('direction');
                        const contextRadios = document.getElementsByName('context');
                        const precisionRadios = document.getElementsByName('precision');
                        const clearButton = document.getElementById('clearButton');
                        const ddInput = document.getElementById('ddInput');
                        const dmsInput = document.getElementById('dmsInput');
                        const coordinateContext = document.getElementById('coordinateContext');
                        
                        // Output elements
                        const output = document.getElementById('output');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const ddDisplay = document.getElementById('ddDisplay');
                        const dmsDisplay = document.getElementById('dmsDisplay');
                        const radiansDisplay = document.getElementById('radiansDisplay');
                        const gradiansDisplay = document.getElementById('gradiansDisplay');
                        const milsDisplay = document.getElementById('milsDisplay');
                        const quadrant = document.getElementById('quadrant');
                        const angleType = document.getElementById('angleType');
                        const referenceAngle = document.getElementById('referenceAngle');
                        const contextType = document.getElementById('contextType');
                        const validRange = document.getElementById('validRange');
                        const copyResult = document.getElementById('copyResult');

                        function getPrecision() {
                            const selected = document.querySelector('input[name="precision"]:checked').value;
                            return selected === 'auto' ? 'auto' : parseInt(selected);
                        }

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked').value;
                        }

                        function getDirection() {
                            return document.querySelector('input[name="direction"]:checked').value;
                        }

                        function getContext() {
                            return document.querySelector('input[name="context"]:checked').value;
                        }

                        function formatNumber(num, precision = 'auto') {
                            if (precision === 'auto') {
                                if (Math.abs(num) >= 1000) {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                                } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                    return Number(num.toPrecision(4)).toExponential();
                                } else if (Math.abs(num) < 1) {
                                    return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                                } else {
                                    return num.toLocaleString(undefined, { maximumFractionDigits: 6 });
                                }
                            } else {
                                if (num !== 0 && Math.abs(num) < 0.5 * Math.pow(10, -precision)) {
                                    return Math.abs(num) < 0.000001 ? Number(num.toPrecision(4)).toExponential() : num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                                }
                                return num.toLocaleString(undefined, { maximumFractionDigits: precision });
                            }
                        }

                        function convertToDMS(decimal) {
                            const abs = Math.abs(decimal);
                            const deg = Math.floor(abs);
                            const min = Math.floor((abs - deg) * 60);
                            const sec = ((abs - deg) * 60 - min) * 60;
                            return { degrees: deg, minutes: min, seconds: sec };
                        }

                        function convertToDD(deg, min, sec, direction) {
                            let decimal = deg + min/60 + sec/3600;
                            if (direction === 'negative' || direction === 'S' || direction === 'W') {
                                decimal = -decimal;
                            }
                            return decimal;
                        }

                        function getQuadrant(angle) {
                            const normalized = ((angle % 360) + 360) % 360;
                            if (normalized >= 0 && normalized < 90) return 'I (0° - 90°)';
                            if (normalized >= 90 && normalized < 180) return 'II (90° - 180°)';
                            if (normalized >= 180 && normalized < 270) return 'III (180° - 270°)';
                            return 'IV (270° - 360°)';
                        }

                        function getAngleType(angle) {
                            const abs = Math.abs(angle);
                            if (abs === 0) return 'Zero angle';
                            if (abs < 90) return 'Acute angle';
                            if (abs === 90) return 'Right angle';
                            if (abs < 180) return 'Obtuse angle';
                            if (abs === 180) return 'Straight angle';
                            if (abs < 360) return 'Reflex angle';
                            return 'Full rotation+';
                        }

                        function getReferenceAngle(angle) {
                            const normalized = Math.abs(angle % 360);
                            if (normalized <= 90) return normalized;
                            if (normalized <= 180) return 180 - normalized;
                            if (normalized <= 270) return normalized - 180;
                            return 360 - normalized;
                        }

                        function updateContextDisplay() {
                            const context = getContext();
                            if (context === 'general') {
                                coordinateContext.style.display = 'none';
                            } else {
                                coordinateContext.style.display = 'block';
                                contextType.textContent = context === 'latitude' ? 'Latitude' : 'Longitude';
                                validRange.textContent = context === 'latitude' ? '-90° to +90°' : '-180° to +180°';
                            }
                        }

                        function updateInterface() {
                            const mode = getMode();
                            if (mode === 'dd-to-dms') {
                                ddInput.style.display = 'block';
                                dmsInput.style.display = 'none';
                                resultTitle.textContent = 'DMS Format';
                                resultDescription.textContent = 'Degrees Minutes Seconds';
                            } else {
                                ddInput.style.display = 'none';
                                dmsInput.style.display = 'block';
                                resultTitle.textContent = 'Decimal Degrees';
                                resultDescription.textContent = 'Decimal format';
                            }
                            updateContextDisplay();
                        }

                        function validateCoordinateRange(value, context) {
                            if (context === 'latitude') {
                                return value >= -90 && value <= 90;
                            } else if (context === 'longitude') {
                                return value >= -180 && value <= 180;
                            }
                            return true; // General angles have no restrictions
                        }

                        function convert() {
                            const mode = getMode();
                            const precision = getPrecision();
                            const context = getContext();
                            let ddValue, dmsValue;

                            if (mode === 'dd-to-dms') {
                                const dd = parseFloat(decimalDegrees.value);
                                if (!isNaN(dd)) {
                                    // Validate range for coordinate contexts
                                    if (!validateCoordinateRange(dd, context)) {
                                        output.textContent = 'Out of range!';
                                        clearDisplays();
                                        return;
                                    }

                                    ddValue = dd;
                                    const dms = convertToDMS(dd);
                                    let direction = '';
                                    let sign = '';
                                    
                                    if (context === 'latitude') {
                                        direction = dd >= 0 ? ' N' : ' S';
                                    } else if (context === 'longitude') {
                                        direction = dd >= 0 ? ' E' : ' W';
                                    } else {
                                        sign = dd < 0 ? '-' : '';
                                    }
                                    
                                    dmsValue = `${sign}${dms.degrees}° ${dms.minutes}' ${formatNumber(dms.seconds, precision)}"${direction}`;
                                    output.textContent = dmsValue;
                                } else {
                                    ddValue = null;
                                    output.textContent = '--';
                                }
                            } else {
                                const deg = parseFloat(degrees.value) || 0;
                                const min = parseFloat(minutes.value) || 0;
                                const sec = parseFloat(seconds.value) || 0;
                                const dir = getDirection();
                                
                                if (deg >= 0 || min >= 0 || sec >= 0) {
                                    ddValue = convertToDD(deg, min, sec, dir);
                                    
                                    // Validate range for coordinate contexts
                                    if (!validateCoordinateRange(ddValue, context)) {
                                        output.textContent = 'Out of range!';
                                        clearDisplays();
                                        return;
                                    }

                                    const dms = convertToDMS(ddValue);
                                    let displayDir = dir;
                                    if (dir === 'positive') displayDir = '+';
                                    if (dir === 'negative') displayDir = '-';
                                    
                                    dmsValue = `${dms.degrees}° ${dms.minutes}' ${formatNumber(dms.seconds, precision)}" ${displayDir}`;
                                    output.textContent = formatNumber(ddValue, precision) + '°';
                                } else {
                                    ddValue = null;
                                    output.textContent = '--';
                                }
                            }

                            // Update all displays
                            if (ddValue !== null) {
                                ddDisplay.textContent = formatNumber(ddValue, precision) + '°';
                                const dms = convertToDMS(ddValue);
                                let dir = '';
                                let sign = '';
                                
                                if (context === 'latitude') {
                                    dir = ddValue >= 0 ? ' N' : ' S';
                                } else if (context === 'longitude') {
                                    dir = ddValue >= 0 ? ' E' : ' W';
                                } else {
                                    sign = ddValue < 0 ? '-' : '';
                                }
                                
                                dmsDisplay.textContent = `${sign}${dms.degrees}° ${dms.minutes}' ${formatNumber(dms.seconds, precision)}"${dir}`;
                                
                                // Additional formats
                                radiansDisplay.textContent = formatNumber(ddValue * Math.PI / 180, precision) + ' rad';
                                gradiansDisplay.textContent = formatNumber(ddValue * 400 / 360, precision) + ' gon';
                                milsDisplay.textContent = formatNumber(ddValue * 6400 / 360, precision) + ' mil';
                                
                                // Angle analysis
                                quadrant.textContent = getQuadrant(ddValue);
                                angleType.textContent = getAngleType(ddValue);
                                referenceAngle.textContent = formatNumber(getReferenceAngle(ddValue), precision) + '°';
                            } else {
                                clearDisplays();
                            }
                        }

                        function clearDisplays() {
                            ddDisplay.textContent = '--';
                            dmsDisplay.textContent = '--';
                            radiansDisplay.textContent = '--';
                            gradiansDisplay.textContent = '--';
                            milsDisplay.textContent = '--';
                            quadrant.textContent = '--';
                            angleType.textContent = '--';
                            referenceAngle.textContent = '--';
                        }

                        function clearAll() {
                            decimalDegrees.value = '';
                            degrees.value = '';
                            minutes.value = '';
                            seconds.value = '';
                            convert();
                            const mode = getMode();
                            if (mode === 'dd-to-dms') {
                                decimalDegrees.focus();
                            } else {
                                degrees.focus();
                            }
                        }

                        // Event listeners
                        decimalDegrees.addEventListener('input', convert);
                        degrees.addEventListener('input', convert);
                        minutes.addEventListener('input', convert);
                        seconds.addEventListener('input', convert);
                        
                        modeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateInterface();
                                convert();
                            });
                        });

                        directionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        contextRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateContextDisplay();
                                convert();
                            });
                        });

                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        clearButton.addEventListener('click', clearAll);

                        // Copy functionality
                        copyResult.addEventListener('click', function() {
                            const text = output.textContent;
                            if (text !== '--' && text !== 'Out of range!') {
                                navigator.clipboard.writeText(text).then(() => {
                                    this.textContent = 'Copied!';
                                    setTimeout(() => {
                                        this.textContent = 'Copy Result';
                                    }, 2000);
                                });
                            }
                        });

                        // Sample values
                        const sampleValues = document.querySelectorAll('.sample-value');
                        sampleValues.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                
                                // Switch to DD mode and set value
                                document.querySelector('input[value="dd-to-dms"]').checked = true;
                                updateInterface();
                                decimalDegrees.value = value;
                                convert();
                                
                                // Update button styles
                                sampleValues.forEach(btn => btn.classList.remove('bg-blue-100', 'text-blue-700'));
                                sampleValues.forEach(btn => btn.classList.add('bg-gray-100', 'text-gray-700'));
                                this.classList.remove('bg-gray-100', 'text-gray-700');
                                this.classList.add('bg-blue-100', 'text-blue-700');
                            });
                        });

                        // Clickable examples
                        const examples = document.querySelectorAll('[data-sample]');
                        examples.forEach(element => {
                            element.addEventListener('click', function() {
                                const value = this.getAttribute('data-sample');
                                
                                // Switch to DD mode and set value
                                document.querySelector('input[value="dd-to-dms"]').checked = true;
                                updateInterface();
                                decimalDegrees.value = value;
                                convert();
                                decimalDegrees.focus();
                            });
                        });

                        // Initialize
                        updateInterface();
                        decimalDegrees.focus();
                        convert();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                clearAll();
                            } else if (e.ctrlKey && e.key === 'm') {
                                e.preventDefault();
                                const currentMode = getMode();
                                const newMode = currentMode === 'dd-to-dms' ? 'dms-to-dd' : 'dd-to-dms';
                                document.querySelector(`input[value="${newMode}"]`).checked = true;
                                updateInterface();
                                convert();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
