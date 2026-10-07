/**
 * Bella's Cafe menu tabs.
 * Tabs are real links (?menu_tab=…) so they work without JavaScript; this
 * script intercepts clicks to switch tabs instantly without a reload.
 */
(function () {
	"use strict";

	function activateTab(link) {
		var slug = link.getAttribute("data-tab");
		if (!slug) {
			return false; // let the browser navigate instead
		}
		var container = link.closest(".bellas-menu-container");
		if (!container || !container.querySelector("#" + slug)) {
			return false;
		}

		container.querySelectorAll(".bellas-tab-content").forEach(function (panel) {
			panel.style.display = panel.id === slug ? "block" : "none";
		});
		container.querySelectorAll(".bellas-tab-btn").forEach(function (btn) {
			btn.classList.toggle("active", btn === link);
		});

		// Keep the URL shareable without reloading.
		var url = new URL(window.location.href);
		url.searchParams.set("menu_tab", slug);
		window.history.replaceState({}, "", url);
		return true;
	}

	document.addEventListener("click", function (event) {
		var link = event.target.closest(".bellas-tab-btn");
		if (!link) {
			return;
		}
		if (activateTab(link)) {
			event.preventDefault();
		}
	});
})();
