<?php
require 'includes/db.php';
require 'includes/header.php';
?>

<main>
    <h1>Добро пожаловать в зоомагазин "Хамелеон"!</h1>

    <section class="reviews">
        <h2>Отзывы наших клиентов</h2>
        <div class="review-list">
            <div class="review">
                <div class="review-header">
                    <span class="review-author">Иван Иванов</span>
                    <span class="review-date">01.10.2025</span>
                </div>
                <p class="review-text">Отличный магазин! Быстрая доставка, качественные товары. Рекомендую!</p>
            </div>
            <div class="review">
                <div class="review-header">
                    <span class="review-author">Мария Петрова</span>
                    <span class="review-date">25.09.2025</span>
                </div>
                <p class="review-text">Заказывала корм для кошки. Все пришло быстро, упаковка целая. Спасибо!</p>
            </div>
            <div class="review">
                <div class="review-header">
                    <span class="review-author">Алексей Смирнов</span>
                    <span class="review-date">15.09.2025</span>
                </div>
                <p class="review-text">Огромный выбор товаров для животных. Цены приятно радуют. Буду   заказывать еще!</p>
            </div>
        </div>
    </section>

    <h2>Мы на карте</h2>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d193776.72278805423!2d83.55113690578696!3d53.33429292158461!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x42dda1e8c72eeeab%3A0xb0e7bbef8d87b503!2z0JHQsNGA0L3QsNGD0LssINCQ0LvRgtCw0LnRgdC60LjQuSDQutGA0LDQuQ!5e1!3m2!1sru!2sru!4v1738609152434!5m2!1sru!2sru" width="1200" height="800" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</main>

<?php require 'includes/footer.php'; ?>