function qs(sel, root = document) {
  return root.querySelector(sel);
}

function qsa(sel, root = document) {
  return Array.from(root.querySelectorAll(sel));
}

const apiBase = (() => {
  // Works for XAMPP setups like:
  // http://localhost/ProyectoNuevo/frontend/
  // and Laravel served at:
  // http://localhost/ProyectoNuevo/backend/api/public/
  const { origin, pathname } = window.location;
  const basePath = pathname.includes("/frontend")
    ? pathname.split("/frontend")[0]
    : pathname.replace(/\/$/, "");
  return `${origin}${basePath}/backend/api/public`;
})();

async function postSolicitudCita(payload) {
  const params = new URLSearchParams();
  Object.entries(payload).forEach(([k, v]) => {
    if (v === null || typeof v === "undefined") return;
    params.set(k, String(v));
  });

  const res = await fetch(`${apiBase}/api/solicitudes-citas`, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8",
      Accept: "application/json",
    },
    body: params.toString(),
  });
  const json = await res.json().catch(() => null);
  if (!res.ok) {
    const details = json && json.errors ? JSON.stringify(json.errors) : "Error desconocido";
    throw new Error(details);
  }
  return json;
}

function safeShowModal(dialog) {
  if (!dialog) return;
  if (typeof dialog.showModal === "function") dialog.showModal();
  else dialog.removeAttribute("hidden");
}

function safeCloseModal(dialog) {
  if (!dialog) return;
  if (typeof dialog.close === "function") dialog.close();
  else dialog.setAttribute("hidden", "");
}

function setYear() {
  const el = qs("[data-year]");
  if (el) el.textContent = String(new Date().getFullYear());
}

function setupStickyHeader() {
  const header = qs("[data-header]");
  if (!header) return;

  const onScroll = () => {
    const y = window.scrollY || 0;
    header.style.boxShadow = y > 8 ? "0 10px 18px rgba(11, 19, 32, 0.08)" : "none";
  };

  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });
}

function setupDrawer() {
  const toggle = qs("[data-menu-toggle]");
  const closeBtns = qsa("[data-menu-close]");
  const drawer = qs("[data-drawer]");
  const drawerLinks = qsa("[data-drawer-link]");

  if (!toggle || !drawer) return;

  const open = () => {
    drawer.hidden = false;
    toggle.setAttribute("aria-expanded", "true");
    document.documentElement.style.overflow = "hidden";
  };

  const close = () => {
    drawer.hidden = true;
    toggle.setAttribute("aria-expanded", "false");
    document.documentElement.style.overflow = "";
  };

  toggle.addEventListener("click", () => {
    if (drawer.hidden) open();
    else close();
  });

  closeBtns.forEach((b) => b.addEventListener("click", close));
  drawerLinks.forEach((a) => a.addEventListener("click", close));
  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") close();
  });
}

function setupAppointmentModal() {
  const openBtns = qsa("[data-open-appointment]");
  const dialog = qs("[data-appointment-modal]");
  const form = qs("[data-appointment-form]");
  if (!dialog) return;

  openBtns.forEach((b) =>
    b.addEventListener("click", () => {
      safeShowModal(dialog);
    })
  );

  if (form) {
    form.addEventListener("submit", async (e) => {
      const submitter = e.submitter;
      if (!submitter || submitter.value !== "confirm") return;

      e.preventDefault();
      const data = new FormData(form);

      const payload = {
        nombre: String(data.get("name") || "").trim(),
        telefono: String(data.get("phone") || "").trim(),
        email: String(data.get("email") || "").trim() || null,
        especialidad: String(data.get("specialty") || "").trim() || null,
        fecha: String(data.get("date") || "").trim() || null,
        // optional: we don't ask time in UI yet
        hora: null,
        motivo: String(data.get("reason") || "").trim() || null,
        origen: "web",
      };

      try {
        await postSolicitudCita(payload);

        safeCloseModal(dialog);
        form.reset();
        window.setTimeout(() => {
          alert("Solicitud registrada. Te contactaremos para confirmar disponibilidad.");
        }, 50);
      } catch (err) {
        alert(
          "No pude registrar la solicitud en el backend. " +
            "Verifica que Laravel esté corriendo y que la URL sea accesible.\n\n" +
            String(err && err.message ? err.message : err)
        );
      }
    });
  }
}

function setupSearchModal() {
  const openBtn = qs("[data-open-search]");
  const dialog = qs("[data-search-modal]");
  const form = qs("[data-search-form]");
  if (!openBtn || !dialog) return;

  openBtn.addEventListener("click", () => safeShowModal(dialog));

  if (form) {
    form.addEventListener("submit", (e) => {
      const submitter = e.submitter;
      if (submitter && submitter.value === "confirm") {
        e.preventDefault();
        const q = String(new FormData(form).get("q") || "").trim().toLowerCase();
        safeCloseModal(dialog);
        if (!q) return;

        const links = qsa(".menu__link");
        const match = links.find((a) => a.textContent.toLowerCase().includes(q));
        if (match) match.click();
        else alert("No encontré una sección con ese texto. Prueba: especialidades, sedes, seguros.");
      }
    });
  }
}

function setupContactForm() {
  const form = qs("[data-contact-form]");
  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const data = new FormData(form);
    const name = String(data.get("name") || "").trim();

    const payload = {
      nombre: name,
      telefono: String(data.get("phone") || "").trim(),
      email: null,
      especialidad: String(data.get("specialty") || "").trim() || null,
      fecha: null,
      hora: null,
      motivo: String(data.get("message") || "").trim() || null,
      origen: "web-contacto",
    };

    try {
      await postSolicitudCita(payload);
      form.reset();
      alert(`Gracias${name ? `, ${name}` : ""}. Registramos tu solicitud y te contactaremos.`);
    } catch (err) {
      alert(
        "No pude registrar tu mensaje en el backend.\n\n" +
          String(err && err.message ? err.message : err)
      );
    }
  });
}

setYear();
setupStickyHeader();
setupDrawer();
setupAppointmentModal();
setupSearchModal();
setupContactForm();

