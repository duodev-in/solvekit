/**
 * Display currency for every calculator that shows money. The viewer picks it from the currency menu in the
 * options bar; the choice is remembered in this browser and applied on every page that lets you change it.
 * Pages tied to one country's rules (US tax, UK tax, Indian schemes) set a fixed currency instead.
 * Amounts are not converted: the calculation is the same in any currency, only the symbol and digit grouping change.
 */
export const CURRENCIES = [
    ['USD', 'US dollar', '$'],
    ['INR', 'Indian rupee', '₹'],
    ['EUR', 'Euro', '€'],
    ['GBP', 'British pound', '£'],
    ['JPY', 'Japanese yen', '¥'],
    ['CNY', 'Chinese yuan', 'CN¥'],
    ['AUD', 'Australian dollar', 'A$'],
    ['CAD', 'Canadian dollar', 'C$'],
    ['NZD', 'New Zealand dollar', 'NZ$'],
    ['CHF', 'Swiss franc', 'CHF '],
    ['SGD', 'Singapore dollar', 'S$'],
    ['HKD', 'Hong Kong dollar', 'HK$'],
    ['AED', 'UAE dirham', 'AED '],
    ['SAR', 'Saudi riyal', 'SAR '],
    ['QAR', 'Qatari riyal', 'QAR '],
    ['KWD', 'Kuwaiti dinar', 'KD '],
    ['BHD', 'Bahraini dinar', 'BD '],
    ['OMR', 'Omani rial', 'OMR '],
    ['PKR', 'Pakistani rupee', 'Rs '],
    ['BDT', 'Bangladeshi taka', '৳'],
    ['LKR', 'Sri Lankan rupee', 'Rs '],
    ['NPR', 'Nepalese rupee', 'Rs '],
    ['PHP', 'Philippine peso', '₱'],
    ['IDR', 'Indonesian rupiah', 'Rp '],
    ['MYR', 'Malaysian ringgit', 'RM '],
    ['THB', 'Thai baht', '฿'],
    ['VND', 'Vietnamese dong', '₫'],
    ['KRW', 'South Korean won', '₩'],
    ['TWD', 'New Taiwan dollar', 'NT$'],
    ['ZAR', 'South African rand', 'R '],
    ['NGN', 'Nigerian naira', '₦'],
    ['KES', 'Kenyan shilling', 'KSh '],
    ['GHS', 'Ghanaian cedi', 'GH₵'],
    ['EGP', 'Egyptian pound', 'E£'],
    ['MAD', 'Moroccan dirham', 'MAD '],
    ['BRL', 'Brazilian real', 'R$'],
    ['MXN', 'Mexican peso', 'MX$'],
    ['ARS', 'Argentine peso', 'AR$'],
    ['CLP', 'Chilean peso', 'CLP$'],
    ['COP', 'Colombian peso', 'COL$'],
    ['PEN', 'Peruvian sol', 'S/ '],
    ['RUB', 'Russian ruble', '₽'],
    ['TRY', 'Turkish lira', '₺'],
    ['UAH', 'Ukrainian hryvnia', '₴'],
    ['PLN', 'Polish złoty', 'zł '],
    ['CZK', 'Czech koruna', 'Kč '],
    ['HUF', 'Hungarian forint', 'Ft '],
    ['SEK', 'Swedish krona', 'SEK '],
    ['NOK', 'Norwegian krone', 'NOK '],
    ['DKK', 'Danish krone', 'DKK '],
    ['ILS', 'Israeli shekel', '₪'],
];

const BY_CODE = new Map(CURRENCIES.map((row) => [row[0], row]));
const STORAGE_KEY = 'solvekit-currency';
let current = 'USD';

export const isCurrency = (code) => BY_CODE.has(code);
export const getCurrency = () => current;

export function setCurrency(code) {
    if (BY_CODE.has(code)) {
        current = code;
    }

    return current;
}

export const currencySymbol = (code = current) => (BY_CODE.get(code) ?? BY_CODE.get('USD'))[2];

/**
 * Minor-unit digits for a currency (2 for most, 0 for yen, won, dong; 3 for the Gulf dinars).
 */
export function currencyDecimals(code = current) {
    try {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: code }).resolvedOptions().maximumFractionDigits;
    } catch {
        return 2;
    }
}

/**
 * Formats an amount in a currency: ₹12,34,567.50 with Indian lakh/crore grouping for rupees, $1,234,567.50 style otherwise.
 * `decimals` overrides the currency's usual minor-unit digits (0 for rounded totals).
 */
export function formatMoney(value, { code = current, decimals = null } = {}) {
    if (!Number.isFinite(value)) {
        return '—';
    }

    const places = decimals ?? currencyDecimals(code);
    const locale = code === 'INR' ? 'en-IN' : 'en-US';
    const text = new Intl.NumberFormat(locale, { minimumFractionDigits: places, maximumFractionDigits: places }).format(Math.abs(value));
    const negative = value < 0 && Number(text.replace(/,/g, '')) !== 0;

    return `${negative ? '−' : ''}${currencySymbol(code)}${text}`;
}

/**
 * The currency remembered in this browser, or null (private windows and blocked storage return null).
 */
export function storedCurrency() {
    try {
        const code = window.localStorage.getItem(STORAGE_KEY);

        return BY_CODE.has(code) ? code : null;
    } catch {
        return null;
    }
}

export function rememberCurrency(code) {
    try {
        window.localStorage.setItem(STORAGE_KEY, code);
    } catch {
        // Storage can be unavailable; the choice still applies to this page.
    }
}
