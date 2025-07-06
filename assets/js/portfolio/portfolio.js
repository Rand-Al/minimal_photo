/**
 * Простая система портфолио на чистом JavaScript
 *
 * Этот код делает то же самое, что и сложная версия,
 * но использует простые функции и понятную логику
 */

// Переменные для хранения текущего состояния
let currentCategory = "all";
let currentPage = 1;
let isLoading = false;
let hasMoreItems = true;

/**
 * Запускаем все когда страница загрузилась
 */
document.addEventListener("DOMContentLoaded", function () {
    // Проверяем, есть ли на странице наша галерея
    if (document.getElementById("portfolio-grid")) {
        setupEventListeners();
        loadItems("all", 1, false);
    }
});

/**
 * Настраиваем обработчики кликов
 */
function setupEventListeners() {
    // Обработчик для кнопок категорий
    document.addEventListener("click", function (event) {
        // Если кликнули на кнопку категории
        if (event.target.classList.contains("portfolio-categories__item")) {
            event.preventDefault();
            handleCategoryClick(event.target);
        }

        // Если кликнули на "Load More"
        if (event.target.id === "load-more-portfolio") {
            event.preventDefault();
            handleLoadMoreClick();
        }

        // Если кликнули на изображение в галерее
        if (event.target.closest(".portfolio-item")) {
            event.preventDefault();
            openModal(event.target.closest(".portfolio-item"));
        }

        // Если кликнули на крестик или фон модального окна
        if (
            event.target.id === "modal-close" ||
            event.target.id === "modal-overlay"
        ) {
            event.preventDefault();
            closeModal();
        }
    });

    // Закрываем модальное окно по Escape
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeModal();
        }
    });
}

/**
 * Что делать когда кликнули на кнопку категории
 */
function handleCategoryClick(button) {
    const category = button.dataset.category;

    // Убираем активный класс со всех кнопок
    const allButtons = document.querySelectorAll(".portfolio-categories__item");
    allButtons.forEach((btn) => btn.classList.remove("active-category"));

    // Добавляем активный класс на нажатую кнопку
    button.classList.add("active-category");

    // Обновляем наши переменные
    currentCategory = category;
    currentPage = 1;
    hasMoreItems = true;

    // Очищаем галерею и загружаем новые элементы
    document.getElementById("portfolio-grid").innerHTML = "";
    loadItems(category, 1, false);
}

/**
 * Что делать когда кликнули "Load More"
 */
function handleLoadMoreClick() {
    // Загружаем только если не грузим уже и есть что грузить
    if (!isLoading && hasMoreItems) {
        currentPage++;
        loadItems(currentCategory, currentPage, true);
    }
}

/**
 * Главная функция - загружает элементы портфолио с сервера
 *
 * category - какую категорию загружать ('all', 'weddings', etc.)
 * page - какую страницу загружать (1, 2, 3...)
 * append - добавлять к существующим (true) или заменить (false)
 */
function loadItems(category, page, append) {
    // Если уже загружаем - выходим
    if (isLoading) return;

    isLoading = true;
    showLoading();

    // Подготавливаем данные для отправки
    const formData = new FormData();
    formData.append("action", "get_portfolio_items");
    formData.append("category", category);
    formData.append("page", page);
    formData.append("nonce", portfolio_ajax.nonce);

    // Отправляем запрос на сервер
    fetch(portfolio_ajax.ajax_url, {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) // Превращаем ответ в JSON
        .then((data) => {
            if (data.success) {
                // Все хорошо, сервер вернул данные
                hasMoreItems = data.data.has_more;

                // Создаем HTML из полученных данных
                const html = createItemsHTML(data.data.items);

                // Добавляем в галерею
                const grid = document.getElementById("portfolio-grid");
                if (append) {
                    grid.innerHTML += html; // Добавляем к существующему
                } else {
                    grid.innerHTML = html; // Заменяем полностью
                }

                // Показываем или скрываем кнопку "Load More"
                const loadMoreBtn = document.getElementById(
                    "load-more-portfolio"
                );
                if (data.data.has_more) {
                    loadMoreBtn.style.display = "block";
                } else {
                    loadMoreBtn.style.display = "none";
                }

                console.log("Загружено элементов:", data.data.items.length);
            } else {
                // Сервер вернул ошибку
                console.error("Ошибка сервера:", data.data);
                alert("Произошла ошибка при загрузке");
            }
        })
        .catch((error) => {
            // Ошибка сети или другая проблема
            console.error("Ошибка:", error);
            alert("Ошибка сети. Проверьте подключение.");
        })
        .finally(() => {
            // Этот блок выполняется всегда, независимо от успеха или ошибки
            hideLoading();
            isLoading = false;
        });
}

/**
 * Создает HTML код для элементов портфолио
 */
function createItemsHTML(items) {
    let html = "";

    console.log("Создаем HTML для элементов:", items); // Отладка: смотрим что пришло с сервера

    // Проходим по каждому элементу и создаем для него HTML
    for (let i = 0; i < items.length; i++) {
        const item = items[i];

        console.log("Обрабатываем элемент:", item); // Отладка: проверяем каждый элемент

        // Проверяем, есть ли изображение
        if (item.image && item.image.thumbnail) {
            // Важно: убеждаемся что все данные корректно передаются в атрибуты
            const title = item.title || "Без названия";
            const description = item.excerpt || "Описание отсутствует";
            const fullImage = item.image.full || item.image.thumbnail;

            console.log("Данные для элемента:", {
                title,
                description,
                fullImage,
            }); // Отладка

            html += `
                <div class="body-portfolio-page__item img-ibg--portfolio-page img-ibg portfolio-item" 
                     data-title="${escapeHTML(title)}"
                     data-description="${escapeHTML(description)}"
                     data-full-image="${fullImage}">
                    <img src="${item.image.thumbnail}" alt="${escapeHTML(
                title
            )}" />
                </div>
            `;
        }
    }

    console.log("Созданный HTML:", html); // Отладка: проверяем итоговый HTML
    return html;
}

/**
 * Открывает модальное окно с увеличенным изображением
 */
function openModal(item) {
    const title = item.dataset.title;
    const description = item.dataset.description;
    const fullImage = item.dataset.fullImage;

    // Заполняем модальное окно данными
    const modalTitle = document.getElementById("modal-title");
    const modalDescription = document.getElementById("modal-description");
    const modalImage = document.getElementById("modal-image");

    if (modalTitle) modalTitle.textContent = title || "Название отсутствует";
    if (modalDescription)
        modalDescription.textContent = description || "Описание отсутствует";
    if (modalImage) {
        modalImage.src = fullImage || "";
        modalImage.alt = title || "Изображение портфолио";
    }

    // Показываем модальное окно с анимацией
    const modal = document.getElementById("portfolio-modal");
    modal.style.display = "flex"; // Сначала делаем видимым

    // Добавляем класс active через небольшую задержку для запуска анимации
    setTimeout(() => {
        modal.classList.add("active");
    }, 10);

    // Блокируем прокрутку основной страницы
    document.body.classList.add("modal-open");
}

/**
 * Закрывает модальное окно с плавной анимацией
 */
function closeModal() {
    const modal = document.getElementById("portfolio-modal");

    // Убираем класс active для запуска анимации закрытия
    modal.classList.remove("active");

    // Скрываем модальное окно после завершения анимации
    setTimeout(() => {
        modal.style.display = "none";
    }, 300); // 300ms соответствует времени CSS transition

    // Возвращаем прокрутку основной страницы
    document.body.classList.remove("modal-open");
}

/**
 * Показывает индикатор загрузки
 */
function showLoading() {
    document.getElementById("portfolio-loading").style.display = "block";
}

/**
 * Скрывает индикатор загрузки
 */
function hideLoading() {
    document.getElementById("portfolio-loading").style.display = "none";
}

/**
 * Защищает от вредоносного кода в тексте
 */
function escapeHTML(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
}
