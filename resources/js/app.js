import './bootstrap';

import Swiper from 'swiper';
import 'swiper/css/bundle';

document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.swiper', {
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});
