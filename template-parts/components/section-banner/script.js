document.addEventListener("DOMContentLoaded", function () {
  const left = document.querySelector(".container-banner-left");
  const right = document.querySelector(".section-banner__image-stack");
  const pagination = document.querySelector(
    ".section-banner__pagination-container",
  );
  const hasItems =
    document.querySelectorAll(".section-banner__item").length > 0;
  if (!hasItems && typeof banners !== "undefined" && Array.isArray(banners)) {
    banners.forEach((b, index) => {
      const item = document.createElement("div");
      item.className =
        "section-banner__item" + (index === 0 ? " active" : "");
      const content = document.createElement("div");
      content.className = "section-banner__item-content";
      const h3 = document.createElement("h3");
      h3.className = "section-banner__item-type";
      h3.textContent = b.type || "";
      const h2 = document.createElement("h2");
      h2.className = "section-banner__item-text";
      h2.textContent = b.text || "";
      const p = document.createElement("p");
      p.className = "section-banner__item-description";
      p.textContent = b.description || "";
      content.appendChild(h3);
      content.appendChild(h2);
      content.appendChild(p);
      item.appendChild(content);
      const btnTitle = "View About Us";
      if (b.linkUrl) {
        const a = document.createElement("a");
        a.className = "section-banner__item-button";
        a.href = b.linkUrl;
        a.innerHTML =
          btnTitle +
          ' <img class="section-banner__item-button-icon" src="/wp-content/themes/buildpro/assets/images/icon/Arrow_Right.png" alt="Arrow Right">';
        item.appendChild(a);
      } else {
        const button = document.createElement("button");
        button.className = "section-banner__item-button";
        button.disabled = true;
        button.innerHTML =
          btnTitle +
          ' <img class="section-banner__item-button-icon" src="/wp-content/themes/buildpro/assets/images/icon/Arrow_Right.png" alt="Arrow Right">';
        item.appendChild(button);
      }
      left.appendChild(item);
      const img = document.createElement("img");
      img.src = b.image;
      img.alt = b.type || "";
      img.className =
        "section-banner__image" + (index === 0 ? " active" : "");
      right.appendChild(img);
      const btn = document.createElement("button");
      btn.className =
        "section-banner__page " +
        (index === 0 ? "pos-center active" : index === 1 ? "pos-right" : "pos-left");
      btn.disabled = true;
      btn.dataset.index = String(index);
      btn.setAttribute("aria-label", b.type || "");
      const dot = document.createElement("span");
      dot.className = "section-banner__page-dot";
      btn.appendChild(dot);
      pagination.appendChild(btn);
    });
  }

  const items = document.querySelectorAll(".section-banner__item");

  // Nếu không có item hoặc chỉ có 1 item thì không cần chạy animation
  if (items.length <= 1) return;

  let currentIndex = 0;
  const duration = 1; // Thời gian chuyển đổi (giây)
  const intervalTime = 5000; // Thời gian hiển thị mỗi slide (ms)

  // Khởi tạo trạng thái ban đầu (đảm bảo CSS đã set nhưng set lại cho chắc chắn với GSAP)
  gsap.set(items, { y: "100%", opacity: 0, zIndex: 0 });
  gsap.set(items[0], { y: "0%", opacity: 1, zIndex: 1 });

  function nextSlide() {
    const currentItem = items[currentIndex];

    // Tính index tiếp theo (vòng tròn: 0 -> 1 -> 2 -> 0)
    let nextIndex = (currentIndex + 1) % items.length;
    const nextItem = items[nextIndex];

    // Timeline cho chuyển động mượt mà
    const tl = gsap.timeline();

    // Object A (current) di chuyển xuống (y: 0% -> 100%) và mờ dần
    tl.to(
      currentItem,
      {
        y: "100%",
        opacity: 0,
        duration: duration,
        ease: "power2.inOut",
        zIndex: 0,
      },
      0,
    );

    // Object B (next) di chuyển lên (từ y: 100% -> 0%) và hiện dần
    // Lưu ý: CSS đã set initial y: 100% cho các item ẩn
    // Cần set lại trạng thái bắt đầu cho nextItem để đảm bảo nó đi từ dưới lên
    tl.fromTo(
      nextItem,
      { y: "100%", opacity: 0, zIndex: 1 },
      { y: "0%", opacity: 1, duration: duration, ease: "power2.inOut" },
      0, // Chạy cùng lúc với animation của currentItem
    );

    // Cập nhật index
    currentIndex = nextIndex;
  }

  // Chạy interval
  setInterval(nextSlide, intervalTime);
});

document.addEventListener("DOMContentLoaded", function () {
  const images = document.querySelectorAll(
    ".section-banner__image-stack .section-banner__image",
  );
  const pages = document.querySelectorAll(
    ".section-banner__pagination .section-banner__page",
  );

  if (images.length <= 1) return;

  let currentIndex = 0;
  const duration = 1; // giây
  const intervalTime = 5000; // ms
  gsap.set(images, {
    x: "100%",
    opacity: 0,
    zIndex: 0,
    scale: 0.85,
    transformOrigin: "50% 50%",
  });
  gsap.set(images[0], {
    x: "0%",
    opacity: 1,
    zIndex: 1,
    scale: 1,
    transformOrigin: "50% 50%",
  });

  function nextImage() {
    const currentImg = images[currentIndex];
    const nextIndex = (currentIndex + 1) % images.length;
    const nextImg = images[nextIndex];

    const tl = gsap.timeline();

    // A: di chuyển từ trái qua phải (ra khỏi khung về phía phải)
    tl.to(
      currentImg,
      {
        scale: 0.85,
        x: "100%",
        opacity: 0,
        duration: duration,
        ease: "power2.inOut",
        zIndex: 0,
      },
      0,
    );

    tl.fromTo(
      nextImg,
      { x: "100%", opacity: 0, zIndex: 1, scale: 0.85 },
      {
        x: "0%",
        opacity: 1,
        scale: 1,
        duration: duration,
        ease: "power2.inOut",
      },
      0,
    );

    currentIndex = nextIndex;
    updatePagination(currentIndex);
  }
  setInterval(nextImage, intervalTime);

  function updatePagination(idx) {
    pages.forEach((btn, i) => {
      btn.classList.toggle("active", i === idx);
    });
  }
  updatePagination(currentIndex);

  // pagination disabled: no click handlers
});
