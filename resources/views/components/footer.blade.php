<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-4">
                    <svg class="h-8 w-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900">SolveKit</span>
                </div>
                <p class="text-gray-600 max-w-md">
                    Professional conversion tools for engineers, scientists, and technical professionals. Accurate, fast, and reliable calculations for all your conversion needs.
                </p>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-4">Popular Tools</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('conversion.length-and-area-conversions.length') }}" class="hover:text-gray-900 transition-colors duration-200">Length Converter</a></li>
                    <li><a href="{{ route('conversion.volume-and-weight-conversions.weight-converter') }}" class="hover:text-gray-900 transition-colors duration-200">Weight Converter</a></li>
                    <li><a href="{{ route('conversion.engineering-and-technical-conversions.pressure-converter') }}" class="hover:text-gray-900 transition-colors duration-200">Pressure Converter</a></li>
                    <li><a href="{{ route('conversion.volume-and-weight-conversions.volume') }}" class="hover:text-gray-900 transition-colors duration-200">Volume Converter</a></li>
                    <li><a href="{{ route('conversion.engineering-and-technical-conversions.torque-to-hp') }}" class="hover:text-gray-900 transition-colors duration-200">Torque to HP</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('contact.create') }}" class="hover:text-gray-900 transition-colors duration-200">Contact Us</a></li>
                    <li><a href="{{ route('feature-request.create') }}" class="hover:text-gray-900 transition-colors duration-200">Request a feature</a></li>
                    <li><a href="{{ route('report-bug.create') }}" class="font-medium text-primary-600 hover:text-primary-700 transition-colors duration-200">Report a bug</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-200 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-600">
                    © {{ date('Y') }} SolveKit. All rights reserved. Built for precision and reliability.
                </p>
                <div class="mt-4 md:mt-0 text-sm text-gray-500">
                    Last updated: {{ date('F Y') }} | Version 2.1
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-8 right-8 bg-primary-600 text-white p-3 rounded-full shadow-lg hover:bg-primary-700 transition-all duration-200 opacity-0 invisible z-50" aria-label="Back to top">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
    </svg>
</button>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Back to top functionality
    const backToTopButton = document.getElementById('backToTop');
    
    if (backToTopButton) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.add('opacity-0', 'invisible');
                backToTopButton.classList.remove('opacity-100', 'visible');
            }
        });
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>
@endpush