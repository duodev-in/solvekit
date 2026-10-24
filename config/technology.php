<?php

/*
|--------------------------------------------------------------------------
| Technology calculators
|--------------------------------------------------------------------------
|
| Same shape as config/everyday.php. Each tool is listed once; its key,
| route name and view are derived from the category and tool slugs:
|   key        {category}::{tool}
|   route name technology.{category}.{tool}
|   view       technology.{category}.{tool with underscores}
|
| Generated pages share handlers in resources/js/calc/tools/tc-*.js and the
| shared engines in resources/js/calc/tech/ and statistics/.
|
*/

$categories = [
    [
        'slug' => 'tech-and-electronics',
        'title' => 'Tech and Electronics',
        'description' => 'Electronics and PCB design, batteries, computing, codes, ciphers and text tools',
        'tools' => [
            ['slug' => '3d-printing-cost-calculator', 'title' => '3D Printing Cost Calculator', 'description' => 'Find what a 3D print costs'],
            ['slug' => 'amdahls-law-calculator', 'title' => 'Amdahl\'s Law Calculator', 'description' => 'Find the speedup from parallel processing'],
            ['slug' => 'ascii-converter', 'title' => 'ASCII Converter', 'description' => 'Convert text and ASCII codes'],
            ['slug' => 'battery-capacity-calculator', 'title' => 'Battery Capacity Calculator', 'description' => 'Convert battery Ah and Wh'],
            ['slug' => 'battery-size-calculator', 'title' => 'Battery Size Calculator', 'description' => 'Size a battery bank'],
            ['slug' => 'binary-to-text-converter', 'title' => 'Binary to Text Converter', 'description' => 'Turn binary into text'],
            ['slug' => 'cable-impedance-calculator', 'title' => 'Cable Impedance Calculator', 'description' => 'Find a cable’s impedance'],
            ['slug' => 'chmod-calculator', 'title' => 'Chmod Calculator', 'description' => 'Work out file permissions'],
            ['slug' => 'cidr-calculator', 'title' => 'CIDR Calculator', 'description' => 'Work with CIDR blocks'],
            ['slug' => 'color-converter', 'title' => 'Color Converter', 'description' => 'Convert colour codes'],
            ['slug' => 'crosstalk-calculator', 'title' => 'Crosstalk Calculator', 'description' => 'Estimate PCB crosstalk'],
            ['slug' => 'drone-flight-time-calculator', 'title' => 'Drone Flight Time Calculator', 'description' => 'Estimate drone flight time'],
            ['slug' => 'drone-motor-calculator', 'title' => 'Drone Motor Calculator', 'description' => 'Find the thrust per motor'],
            ['slug' => 'duty-cycle-calculator', 'title' => 'Duty Cycle Calculator', 'description' => 'Find the duty cycle'],
            ['slug' => 'edpi-calculator', 'title' => 'eDPI Calculator', 'description' => 'Find your eDPI'],
            ['slug' => 'gothic-font-generator', 'title' => 'Gothic Font Generator', 'description' => 'Make gothic text'],
            ['slug' => 'gsd-calculator-ground-sample-distance', 'title' => 'GSD Calculator – Ground Sample Distance', 'description' => 'Find the ground sample distance'],
            ['slug' => 'hamming-code-calculator', 'title' => 'Hamming Code Calculator', 'description' => 'Encode and check Hamming codes'],
            ['slug' => 'hamming-distance-calculator', 'title' => 'Hamming Distance Calculator', 'description' => 'Find the Hamming distance'],
            ['slug' => 'hash-generator', 'title' => 'Hash Generator', 'description' => 'Hash text'],
            ['slug' => 'hash-identifier', 'title' => 'Hash Identifier', 'description' => 'Identify a hash'],
            ['slug' => 'hex-to-text-converter', 'title' => 'Hex-to-Text Converter', 'description' => 'Turn hex into text'],
            ['slug' => 'impedance-matching-calculator', 'title' => 'Impedance Matching Calculator', 'description' => 'Design an L-network match'],
            ['slug' => 'letters-to-numbers-converter', 'title' => 'Letters to Numbers Converter', 'description' => 'Convert letters to numbers'],
            ['slug' => 'lm317-calculator', 'title' => 'LM317 Calculator', 'description' => 'Set an LM317 regulator'],
            ['slug' => 'mirror-text-generator', 'title' => 'Mirror Text Generator', 'description' => 'Make mirror text'],
            ['slug' => 'morse-code-translator', 'title' => 'Morse Code Translator', 'description' => 'Translate Morse code'],
            ['slug' => 'numbers-to-letters-converter', 'title' => 'Numbers to Letters Converter', 'description' => 'Convert numbers to letters'],
            ['slug' => 'parity-bit-calculator', 'title' => 'Parity Bit Calculator', 'description' => 'Find the parity bit'],
            ['slug' => 'pcb-impedance-calculator', 'title' => 'PCB Impedance Calculator', 'description' => 'Estimate PCB trace impedance'],
            ['slug' => 'pcb-trace-current-calculator', 'title' => 'PCB Trace Current Calculator', 'description' => 'Find a trace’s current limit'],
            ['slug' => 'pcb-trace-resistance-calculator', 'title' => 'PCB Trace Resistance Calculator', 'description' => 'Find a trace’s resistance'],
            ['slug' => 'pcb-trace-width-calculator', 'title' => 'PCB Trace Width Calculator', 'description' => 'Find the trace width'],
            ['slug' => 'pi-attenuator-calculator', 'title' => 'Pi Attenuator Calculator', 'description' => 'Design an attenuator'],
            ['slug' => 'propagation-delay-calculator', 'title' => 'Propagation Delay Calculator', 'description' => 'Find the propagation delay'],
            ['slug' => 'raid-calculator', 'title' => 'RAID Calculator', 'description' => 'Plan a RAID array'],
            ['slug' => 'ram-latency-calculator', 'title' => 'RAM Latency Calculator', 'description' => 'Compare memory latency'],
            ['slug' => 'rf-unit-converter', 'title' => 'RF Unit Converter', 'description' => 'Convert RF power units'],
            ['slug' => 'small-caps-generator', 'title' => 'Small Caps Generator', 'description' => 'Make small caps text'],
            ['slug' => 'small-text-generator', 'title' => 'Small Text Generator', 'description' => 'Make small text'],
            ['slug' => 'strikethrough-text-generator', 'title' => 'Strikethrough Text Generator', 'description' => 'Make strikethrough text'],
            ['slug' => 'subscript-generator', 'title' => 'Subscript Generator', 'description' => 'Make subscript text'],
            ['slug' => 'superscript-generator', 'title' => 'Superscript Generator', 'description' => 'Make superscript text'],
            ['slug' => 't9-to-text-converter', 'title' => 'T9 to Text Converter', 'description' => 'Decode keypad presses'],
            ['slug' => 'text-to-binary-converter', 'title' => 'Text to Binary Converter', 'description' => 'Turn text into binary'],
            ['slug' => 'text-to-hexadecimal-converter', 'title' => 'Text-to-Hexadecimal Converter', 'description' => 'Turn text into hex'],
            ['slug' => 'total-harmonic-distortion-calculator', 'title' => 'Total Harmonic Distortion Calculator', 'description' => 'Find total harmonic distortion'],
            ['slug' => 'uuid-generator', 'title' => 'UUID Generator', 'description' => 'Generate UUIDs'],
            ['slug' => 'vigenere-cipher-calculator', 'title' => 'Vigenère Cipher Calculator', 'description' => 'Use the Vigenère cipher'],
        ],
        'elsewhere' => [
            ['route' => 'physics.electronics.battery-life-calculator', 'title' => 'Battery Life Calculator', 'description' => 'Run time from capacity and load (Physics)'],
            ['route' => 'physics.electronics.op-amp-gain-calculator', 'title' => 'Op-Amp Gain Calculator', 'description' => 'Inverting and non-inverting gain (Physics)'],
            ['route' => 'physics.electronics.resistor-color-code-calculator', 'title' => 'Resistor Color Code Calculator', 'description' => 'Bands to ohms and back (Physics)'],
            ['route' => 'math.binary.ieee-754-floating-point-converter', 'title' => 'Floating-Point Calculator', 'description' => 'IEEE 754 single and double precision (Math)'],
            ['route' => 'math.algebra.truth-table-generator', 'title' => 'Logic Gate Calculator', 'description' => 'Truth tables; AND, OR, XOR and other gates are in Math → Binary'],
            ['route' => 'statistics.probability-and-odds.password-combination-calculator', 'title' => 'Password Entropy Calculator', 'description' => 'Combinations and entropy in bits (Statistics)'],
            ['route' => 'everyday.office-school-and-productivity.text-case-converter', 'title' => 'Capital, Sentence and Title Case Converter', 'description' => 'UPPER, lower, Title and Sentence case (Everyday Life)'],
            ['route' => 'everyday.leisure-and-fun.bold-text-generator', 'title' => 'Bold Text Generator', 'description' => 'Also italic, cursive, glitch and upside-down text (Everyday Life)'],
        ],
    ],
    [
        'slug' => 'internet-and-network',
        'title' => 'Internet and Network',
        'description' => 'IP addresses and subnets, transfer times, bandwidth, Base64, streaming and uptime',
        'tools' => [
            ['slug' => 'bandwidth-calculator', 'title' => 'Bandwidth Calculator', 'description' => 'Estimate bandwidth needs'],
            ['slug' => 'bandwidth-delay-product-calculator', 'title' => 'Bandwidth Delay Product Calculator', 'description' => 'Find the bandwidth-delay product'],
            ['slug' => 'base64-encoder-decoder', 'title' => 'Base64 Encoder & Decoder', 'description' => 'Encode and decode Base64'],
            ['slug' => 'baud-rate-calculator', 'title' => 'Baud Rate Calculator', 'description' => 'Convert baud and bit rate'],
            ['slug' => 'data-transfer-calculator', 'title' => 'Data Transfer Calculator', 'description' => 'Find a transfer time'],
            ['slug' => 'download-time-calculator', 'title' => 'Download Time Calculator', 'description' => 'Find a download time'],
            ['slug' => 'ip-address-converter', 'title' => 'IP Address Converter', 'description' => 'Convert an IP address'],
            ['slug' => 'ip-subnet-calculator', 'title' => 'IP Subnet Calculator', 'description' => 'Calculate a subnet'],
            ['slug' => 'streaming-bitrate-calculator', 'title' => 'Streaming Bitrate Calculator', 'description' => 'Find a streaming bitrate'],
            ['slug' => 'upload-time-calculator', 'title' => 'Upload Time Calculator', 'description' => 'Find an upload time'],
            ['slug' => 'uptime-calculator', 'title' => 'Uptime Calculator', 'description' => 'Turn uptime into downtime'],
        ],
        'elsewhere' => [
            ['route' => 'conversion.data-and-technical-conversion-tools.byte-conversion-calculator', 'title' => 'Byte Converter', 'description' => 'Bytes, KB, MB, GB and binary units (Conversion Tools)'],
            ['route' => 'everyday.home-economics.data-usage-calculator', 'title' => 'Data Usage Calculator', 'description' => 'Monthly data for streaming and browsing (Everyday Life)'],
        ],
    ],
    [
        'slug' => 'photo-and-video',
        'title' => 'Photo and Video',
        'description' => 'Lenses, depth of field, exposure, timecode, screens, file sizes and golden hour',
        'tools' => [
            ['slug' => '3d-render-calculator', 'title' => '3D Render Calculator', 'description' => 'Estimate render time'],
            ['slug' => 'aspect-ratio-calculator', 'title' => 'Aspect Ratio Calculator', 'description' => 'Find an aspect ratio'],
            ['slug' => 'blink-free-photo-calculator', 'title' => 'Blink-free Photo Calculator', 'description' => 'Avoid blinks in group photos'],
            ['slug' => 'camera-field-of-view-calculator', 'title' => 'Camera Field of View Calculator', 'description' => 'Find the field of view'],
            ['slug' => 'contrast-ratio-calculator', 'title' => 'Contrast Ratio Calculator', 'description' => 'Check colour contrast'],
            ['slug' => 'crop-factor-calculator', 'title' => 'Crop Factor Calculator', 'description' => 'Find the crop factor'],
            ['slug' => 'depth-of-field-calculator', 'title' => 'Depth of Field Calculator', 'description' => 'Find the depth of field'],
            ['slug' => 'exposure-calculator', 'title' => 'Exposure Calculator', 'description' => 'Work out exposure settings'],
            ['slug' => 'film-calculator', 'title' => 'Film Calculator', 'description' => 'Plan film stock'],
            ['slug' => 'flash-guide-number-calculator', 'title' => 'Flash Guide Number Calculator', 'description' => 'Use a flash guide number'],
            ['slug' => 'focal-length-calculator', 'title' => 'Focal Length Calculator', 'description' => 'Find the focal length you need'],
            ['slug' => 'frames-to-timecode-calculator', 'title' => 'Frames to Timecode Calculator', 'description' => 'Convert frames to timecode'],
            ['slug' => 'golden-hour-calculator', 'title' => 'Golden Hour Calculator', 'description' => 'Find the golden hour'],
            ['slug' => 'hyperfocal-distance-calculator', 'title' => 'Hyperfocal Distance Calculator', 'description' => 'Find the hyperfocal distance'],
            ['slug' => 'image-file-size-calculator', 'title' => 'Image File Size Calculator', 'description' => 'Find an image file size'],
            ['slug' => 'image-ratio-calculator', 'title' => 'Image Ratio Calculator', 'description' => 'Resize or crop an image'],
            ['slug' => 'megapixel-calculator', 'title' => 'Megapixel Calculator', 'description' => 'Find megapixels and print size'],
            ['slug' => 'ppi-calculator-pixels-per-inch', 'title' => 'PPI Calculator (Pixels Per Inch)', 'description' => 'Find a screen’s pixel density'],
            ['slug' => 'projector-calculator', 'title' => 'Projector Calculator', 'description' => 'Place a projector'],
            ['slug' => 'resolution-scale-calculator', 'title' => 'Resolution Scale Calculator', 'description' => 'Scale a resolution'],
            ['slug' => 'screen-size-calculator', 'title' => 'Screen Size Calculator', 'description' => 'Find a screen’s width and height'],
            ['slug' => 'shutter-speed-calculator', 'title' => 'Shutter Speed Calculator', 'description' => 'Find a safe shutter speed'],
            ['slug' => 'time-lapse-calculator', 'title' => 'Time Lapse Calculator', 'description' => 'Plan a time-lapse'],
            ['slug' => 'timecode-to-frames-calculator', 'title' => 'Timecode to Frames Calculator', 'description' => 'Convert timecode to frames'],
            ['slug' => 'tv-mounting-height-calculator', 'title' => 'TV Mounting Height Calculator', 'description' => 'Find the TV mounting height'],
            ['slug' => 'tv-size-calculator', 'title' => 'TV Size Calculator', 'description' => 'Find the right TV size'],
            ['slug' => 'vertical-exaggeration-calculator', 'title' => 'Vertical Exaggeration Calculator', 'description' => 'Find the vertical exaggeration'],
            ['slug' => 'video-file-size-calculator-by-format', 'title' => 'Video File Size Calculator (by format)', 'description' => 'Find a video file size'],
            ['slug' => 'video-frame-size-calculator', 'title' => 'Video Frame Size Calculator', 'description' => 'Find an uncompressed frame size'],
        ],
        'elsewhere' => [
            ['route' => 'physics.optics.thin-lens-equation-calculator', 'title' => 'Magnification of a Lens Calculator', 'description' => 'Image distance and magnification (Physics)'],
            ['route' => 'conversion.length-and-area-conversions.pixels-to-inches', 'title' => 'Pixels to Print Size Calculator', 'description' => 'Pixels to inches at any DPI (Conversion Tools)'],
        ],
    ],
    [
        'slug' => 'music-and-audio',
        'title' => 'Music and Audio',
        'description' => 'Notes, chords, scales, keys, tempo, frets, strings and loudspeaker boxes',
        'tools' => [
            ['slug' => 'audio-file-size-calculator', 'title' => 'Audio File Size Calculator', 'description' => 'Find an audio file size'],
            ['slug' => 'bpm-calculator', 'title' => 'BPM Calculator', 'description' => 'Find the tempo in BPM'],
            ['slug' => 'cents-calculator', 'title' => 'Cents Calculator', 'description' => 'Measure intervals in cents'],
            ['slug' => 'chord-calculator', 'title' => 'Chord Calculator', 'description' => 'Find the notes of a chord'],
            ['slug' => 'chord-finder', 'title' => 'Chord Finder', 'description' => 'Name a chord from its notes'],
            ['slug' => 'chord-inversion-calculator', 'title' => 'Chord Inversion Calculator', 'description' => 'Find chord inversions'],
            ['slug' => 'chord-progression-generator', 'title' => 'Chord Progression Generator', 'description' => 'Build a chord progression'],
            ['slug' => 'chord-transposer', 'title' => 'Chord Transposer', 'description' => 'Transpose a chord chart'],
            ['slug' => 'delay-and-reverb-calculator', 'title' => 'Delay and Reverb Calculator', 'description' => 'Sync delay to the tempo'],
            ['slug' => 'fret-calculator', 'title' => 'Fret Calculator', 'description' => 'Find fret positions'],
            ['slug' => 'guitar-string-tension-calculator', 'title' => 'Guitar String Tension Calculator', 'description' => 'Find string tension'],
            ['slug' => 'harmonic-series-calculator', 'title' => 'Harmonic Series Calculator', 'description' => 'List the harmonic series'],
            ['slug' => 'key-signature-calculator', 'title' => 'Key Signature Calculator', 'description' => 'Find a key signature'],
            ['slug' => 'music-duration-calculator', 'title' => 'Music Duration Calculator', 'description' => 'Find how long a piece lasts'],
            ['slug' => 'music-interval-calculator', 'title' => 'Music Interval Calculator', 'description' => 'Name a music interval'],
            ['slug' => 'music-scale-calculator', 'title' => 'Music Scale Calculator', 'description' => 'Find the notes of a scale'],
            ['slug' => 'music-transposition-calculator', 'title' => 'Music Transposition Calculator', 'description' => 'Transpose for an instrument'],
            ['slug' => 'note-frequency-calculator', 'title' => 'Note Frequency Calculator', 'description' => 'Find a note’s frequency'],
            ['slug' => 'port-length-calculator', 'title' => 'Port Length Calculator', 'description' => 'Find a speaker port length'],
            ['slug' => 'room-mode-calculator', 'title' => 'Room Mode Calculator', 'description' => 'Find a room’s modes'],
            ['slug' => 'semitone-calculator', 'title' => 'Semitone Calculator', 'description' => 'Count semitones'],
            ['slug' => 'speaker-box-calculator', 'title' => 'Speaker Box Calculator', 'description' => 'Size a speaker box'],
            ['slug' => 'speaker-wiring-impedance-calculator', 'title' => 'Speaker Wiring Impedance Calculator', 'description' => 'Wire speakers safely'],
            ['slug' => 'vocal-range-calculator', 'title' => 'Vocal Range Calculator', 'description' => 'Find your voice type'],
        ],
    ],
];

$calculators = [];

foreach ($categories as &$category) {
    foreach ($category['tools'] as &$tool) {
        $tool['key'] = "{$category['slug']}::{$tool['slug']}";
        $tool['route_name'] = "technology.{$category['slug']}.{$tool['slug']}";
        $tool['view'] = "technology.{$category['slug']}.".str_replace('-', '_', $tool['slug']);
        $tool['category_slug'] = $category['slug'];
        $calculators[$tool['key']] = $tool;
    }
    unset($tool);
}
unset($category);

return [
    'categories' => $categories,
    'calculators' => $calculators,
];
