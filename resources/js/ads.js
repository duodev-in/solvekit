/**
 * Activates AdSense units only once they are visible, so units hidden by
 * responsive classes (e.g. `lg:hidden`) never request an ad with zero width.
 */
const activateAdUnit = (unit) => {
	unit.classList.remove('ad-unit-pending');
	unit.classList.add('adsbygoogle');

	try {
		(window.adsbygoogle = window.adsbygoogle || []).push({});
	} catch (error) {
		console.warn('AdSense unit could not be initialised.', error);
	}
};

const isVisible = (unit) => unit.offsetWidth > 0;

export const initAdUnits = () => {
	const pendingUnits = document.querySelectorAll('ins.ad-unit-pending');

	if (pendingUnits.length === 0) {
		return;
	}

	const observer = 'ResizeObserver' in window
		? new ResizeObserver((entries) => {
			entries.forEach(({ target }) => {
				if (isVisible(target)) {
					observer.unobserve(target);
					activateAdUnit(target);
				}
			});
		})
		: null;

	pendingUnits.forEach((unit) => {
		if (isVisible(unit)) {
			activateAdUnit(unit);
		} else {
			observer?.observe(unit);
		}
	});
};
