<x-tool-page-layout
    title="Cubic Yards to Tons Converter - ConvertPro"
    description="Professional cubic yards to tons converter for construction materials. Convert volume to weight for concrete, soil, gravel, and other bulk materials."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Cubic Yards to Tons</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Material Type Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Type of Material
                                                                                </label>
                                                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                                                                    @foreach(['Food', 'Metals', 'Non-metals', 'Gases', 'Liquids'] as $type)
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-purple-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="type" value="{{ $type }}" class="text-purple-600 focus:ring-slate-200" {{ $type === 'Non-metals' ? 'checked' : '' }}>
                                                                                        <span class="text-sm font-medium">{{ $type }}</span>
                                                                                    </label>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>

                                                                            <!-- Material Selection -->
                                                                            <div class="space-y-2">
                                                                                <label for="substance" class="block text-sm font-semibold text-slate-700">
                                                                                    <span id="subLabel">Non-metals</span> Material
                                                                                </label>
                                                                                <select 
                                                                                    id="substance" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="">Select material</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Custom Density Input -->
                                                                            <div class="space-y-2" id="customDensityField" style="display: none;">
                                                                                <label for="customDensity" class="block text-sm font-semibold text-slate-700">
                                                                                    Custom Density
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="customDensity" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter density"
                                                                                        step="1"
                                                                                        min="1"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">kg/m³</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Density Display -->
                                                                            <div class="space-y-2">
                                                                                <label for="density" class="block text-sm font-semibold text-slate-700">
                                                                                    Material Density
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="density" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg bg-gray-50 text-lg font-medium" 
                                                                                        placeholder="Select material first"
                                                                                        readonly
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">kg/m³</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Volume Input -->
                                                                            <div class="space-y-2">
                                                                                <label for="volume" class="block text-sm font-semibold text-slate-700">
                                                                                    Volume
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="volume" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter volume (e.g., 10)"
                                                                                        step="0.01"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">yd³</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + Shift + C to clear</p>
                                                                                <button
                                                                                    type="button"
                                                                                    id="clearButton"
                                                                                    class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                                                                                >
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-4">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result - Metric Tons -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Mass (Metric Tons)</h4>
                                                                                        <p class="text-[11px] text-slate-500">Standard metric weight</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="mass">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">metric tons</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Kilograms</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="kgOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">US Tons</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="usTonsOutput">--</div>
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
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Material Density Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• Concrete: 2400 kg/m³</div>
                                                        <div>• Sand: 1602 kg/m³</div>
                                                        <div>• Gravel: 1680 kg/m³</div>
                                                        <div>• 1 yd³ = 0.765 m³</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Volume to Weight Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Construction Applications</h4>
                                    <p>Essential for ordering concrete, estimating soil needs, calculating aggregate requirements, and determining trucking loads for construction projects.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Material Planning</h4>
                                    <p>Critical for project budgeting, transportation planning, and ensuring adequate structural support for the weight of materials being used.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Construction Tip:</strong> Always verify material densities with your supplier as they can vary based on moisture content and composition!
                                </p>
                            </div>
                        </div>

                        <!-- Common Material Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Construction Materials</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Concrete</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-material="Concrete" data-volume="1">1 yd³</div>
                                    <div class="text-[11px] text-slate-500">~1.8 tons</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Topsoil</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-material="Sand" data-volume="1">1 yd³</div>
                                    <div class="text-[11px] text-slate-500">~1.2 tons</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Gravel</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-material="Asphalt" data-volume="1">1 yd³</div>
                                    <div class="text-[11px] text-slate-500">~1.8 tons</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Clay</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-material="Clay" data-volume="1">1 yd³</div>
                                    <div class="text-[11px] text-slate-500">~1.2 tons</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const typeRadios = document.getElementsByName('type');
                        const substanceSelect = document.getElementById('substance');
                        const subLabel = document.getElementById('subLabel');
                        const customDensityField = document.getElementById('customDensityField');
                        const customDensity = document.getElementById('customDensity');
                        const densityInput = document.getElementById('density');
                        const volumeInput = document.getElementById('volume');
                        const clearButton = document.getElementById('clearButton');
                        const massOutput = document.getElementById('mass');
                        const kgOutput = document.getElementById('kgOutput');
                        const usTonsOutput = document.getElementById('usTonsOutput');

                        const densities = {
                            "Food": {
                                "Rice": 850,
                                "Flour": 593,
                                "Sugar": 845,
                                "Salt": 1200,
                                "Honey": 1420,
                                "Jam": 1340,
                                "Nutella": 1270,
                                "Maple syrup": 1330,
                                "Oats": 380,
                                "Peanut butter": 1100,
                                "Butter": 911,
                                "Custom": null
                            },
                            "Metals": {
                                "Iron": 7870,
                                "Aluminum": 2700,
                                "Copper": 8960,
                                "Lead": 11340,
                                "Steel": 7850,
                                "Gold": 19300,
                                "Silver": 10490,
                                "Custom": null
                            },
                            "Non-metals": {
                                "Concrete": 2400,
                                "Cork": 240,
                                "Diamond": 3515,
                                "Ice": 917,
                                "Nylon": 1150,
                                "Oak": 700,
                                "Pine": 500,
                                "Plastic": 1050,
                                "Styrofoam": 75,
                                "Wood (typical)": 600,
                                "Clay": 1600,
                                "Sand": 1602,
                                "Asphalt": 2300,
                                "Custom": null
                            },
                            "Gases": {
                                "Air": 1.225,
                                "Carbon dioxide": 1.98,
                                "Hydrogen": 0.0899,
                                "Oxygen": 1.331,
                                "Nitrogen": 1.251,
                                "Custom": null
                            },
                            "Liquids": {
                                "Water": 1000,
                                "Milk": 1030,
                                "Oil": 920,
                                "Gasoline": 740,
                                "Mercury": 13546,
                                "Alcohol": 789,
                                "Honey": 1420,
                                "Custom": null
                            }
                        };

                        function populateSubstances(type) {
                            subLabel.textContent = type;
                            substanceSelect.innerHTML = '<option value="">Select material</option>';
                            Object.keys(densities[type]).forEach(item => {
                                substanceSelect.innerHTML += `<option value="${item}">${item}</option>`;
                            });
                        }

                        function formatNumber(num) {
                            if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else if (Math.abs(num) < 1) {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }

                            return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                        }

                        function convert() {
                            const vol = parseFloat(volumeInput.value);
                            const den = parseFloat(densityInput.value);
                            
                            if (!isNaN(vol) && !isNaN(den) && vol > 0 && den > 0) {
                                // Convert cubic yards to cubic meters
                                const m3 = vol * 0.764555;
                                // Calculate mass in kg
                                const kg = m3 * den;
                                // Convert to metric tons
                                const metricTons = kg / 1000;
                                // Convert to US tons
                                const usTons = metricTons * 1.10231;

                                massOutput.textContent = formatNumber(metricTons);
                                kgOutput.textContent = formatNumber(kg) + ' kg';
                                usTonsOutput.textContent = formatNumber(usTons) + ' tons';
                            } else {
                                massOutput.textContent = "--";
                                kgOutput.textContent = "--";
                                usTonsOutput.textContent = "--";
                            }
                        }

                        function selectDefaultMaterial() {
                            document.querySelector('input[name="type"][value="Non-metals"]').checked = true;
                            populateSubstances('Non-metals');
                            substanceSelect.value = 'Concrete';
                            densityInput.value = densities['Non-metals']['Concrete'];
                            customDensityField.style.display = 'none';
                        }

                        function clearAll() {
                            volumeInput.value = '';
                            customDensity.value = '';
                            selectDefaultMaterial();
                            convert();
                            volumeInput.focus();
                        }

                        // Event listeners
                        typeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                populateSubstances(radio.value);
                                densityInput.value = "";
                                customDensityField.style.display = 'none';
                                convert();
                            });
                        });

                        substanceSelect.addEventListener('change', () => {
                            const type = [...typeRadios].find(r => r.checked).value;
                            const substance = substanceSelect.value;
                            const densityValue = densities[type][substance];
                            
                            if (substance === 'Custom') {
                                customDensityField.style.display = 'block';
                                densityInput.value = customDensity.value || '';
                            } else {
                                customDensityField.style.display = 'none';
                                densityInput.value = densityValue !== null ? densityValue : '';
                            }
                            convert();
                        });

                        customDensity.addEventListener('input', () => {
                            densityInput.value = customDensity.value;
                            convert();
                        });

                        volumeInput.addEventListener('input', convert);
                        clearButton.addEventListener('click', clearAll);

                        // Add clickable functionality to example materials
                        const exampleMaterials = document.querySelectorAll('[data-material]');
                        exampleMaterials.forEach(element => {
                            element.addEventListener('click', function() {
                                const material = this.getAttribute('data-material');
                                const volume = this.getAttribute('data-volume');
                                
                                // Find the material in the densities object
                                for (const [type, materials] of Object.entries(densities)) {
                                    if (materials[material]) {
                                        // Select the type
                                        document.querySelector(`input[value="${type}"]`).checked = true;
                                        populateSubstances(type);
                                        
                                        // Select the material
                                        substanceSelect.value = material;
                                        densityInput.value = materials[material];
                                        
                                        // Set volume
                                        volumeInput.value = volume;
                                        
                                        convert();
                                        break;
                                    }
                                }
                            });
                        });

                        // Initialize with concrete so results appear as soon as a volume is entered
                        selectDefaultMaterial();
                        volumeInput.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
