import './bootstrap';
import { initAdUnits } from './ads';

initAdUnits();

document.querySelectorAll('[data-tab-group]').forEach((group) => {
	const tabs = group.querySelectorAll('[data-tab-target]');
	const panels = group.querySelectorAll('[data-tab-panel]');

	tabs.forEach((tab) => {
		tab.addEventListener('click', () => {
			const target = tab.dataset.tabTarget;

			tabs.forEach((item) => {
				const isActive = item === tab;
				item.classList.toggle('border-primary-600', isActive);
				item.classList.toggle('border-transparent', !isActive);
				item.classList.toggle('text-primary-600', isActive);
				item.classList.toggle('text-zinc-500', !isActive);
				item.setAttribute('aria-selected', isActive ? 'true' : 'false');
			});

			panels.forEach((panel) => {
				panel.hidden = panel.dataset.tabPanel !== target;
			});
		});
	});
});

document.querySelectorAll('[data-toast]').forEach((toast) => {
	const progress = toast.querySelector('[data-toast-progress]');
	const dismiss = () => toast.remove();
	const duration = 5000;
	let remaining = duration;
	let startedAt = Date.now();
	let timeout = window.setTimeout(dismiss, remaining);

	const startProgress = () => {
		progress.style.width = '100%';
		progress.style.transition = `width ${remaining}ms linear`;
		requestAnimationFrame(() => {
			progress.style.width = '0%';
		});
		startedAt = Date.now();
	};

	const pause = () => {
		window.clearTimeout(timeout);
		remaining = Math.max(0, remaining - (Date.now() - startedAt));
		progress.style.transition = 'none';
		progress.style.width = `${(remaining / duration) * 100}%`;
	};

	const resume = () => {
		if (remaining <= 0) {
			dismiss();
			return;
		}

		timeout = window.setTimeout(dismiss, remaining);
		startProgress();
	};

	toast.addEventListener('mouseenter', pause);
	toast.addEventListener('mouseleave', resume);
	toast.querySelector('[data-toast-dismiss]')?.addEventListener('click', dismiss);
	startProgress();
});
