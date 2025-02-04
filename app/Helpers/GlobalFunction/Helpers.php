<?php

use App\Models\Language;
use App\Models\OrderRefund;

function checkboxorswitch($data){
    if($data == "on" || $data == 1){
        return "1";
    }else{
        return "2";
    }
}
function statusView($data){
    if($data == 1){
        return __('global.active');
    }else{
        return __('global.passive');
    }
    return "";
}
function yesnoView($data){
    if($data == 1){
        return "Evet";
    }else{
        return "Hayır";
    }
    return "";
}
function array_only($array = array(),$onlykey = null){
    $returndata = Array();
    foreach ($array as $a){
        $returndata[] = $a[$onlykey];
    }
    return $returndata;
}

function getRoleCheck($roleName)
{
    $userRoles = new App\Models\userroles;
    return $userRoles->CheckRole($roleName);
}
function getIcon()
{
    $AllIconList = array("bi-alarm", "bi-alarm-fill", "bi-align-bottom", "bi-align-center", "bi-align-end", "bi-align-middle", "bi-align-start", "bi-align-top", "bi-alt", "bi-app", "bi-app-indicator", "bi-archive", "bi-archive-fill", "bi-arrow-90deg-down", "bi-arrow-90deg-left", "bi-arrow-90deg-right", "bi-arrow-90deg-up", "bi-arrow-bar-down", "bi-arrow-bar-left", "bi-arrow-bar-right", "bi-arrow-bar-up", "bi-arrow-clockwise", "bi-arrow-counterclockwise", "bi-arrow-down", "bi-arrow-down-circle", "bi-arrow-down-circle-fill", "bi-arrow-down-left-circle", "bi-arrow-down-left-circle-fill", "bi-arrow-down-left-square", "bi-arrow-down-left-square-fill", "bi-arrow-down-right-circle", "bi-arrow-down-right-circle-fill", "bi-arrow-down-right-square", "bi-arrow-down-right-square-fill", "bi-arrow-down-square", "bi-arrow-down-square-fill", "bi-arrow-down-left", "bi-arrow-down-right", "bi-arrow-down-short", "bi-arrow-down-up", "bi-arrow-left", "bi-arrow-left-circle", "bi-arrow-left-circle-fill", "bi-arrow-left-square", "bi-arrow-left-square-fill", "bi-arrow-left-right", "bi-arrow-left-short", "bi-arrow-repeat", "bi-arrow-return-left", "bi-arrow-return-right", "bi-arrow-right", "bi-arrow-right-circle", "bi-arrow-right-circle-fill", "bi-arrow-right-square", "bi-arrow-right-square-fill", "bi-arrow-right-short", "bi-arrow-up", "bi-arrow-up-circle", "bi-arrow-up-circle-fill", "bi-arrow-up-left-circle", "bi-arrow-up-left-circle-fill", "bi-arrow-up-left-square", "bi-arrow-up-left-square-fill", "bi-arrow-up-right-circle", "bi-arrow-up-right-circle-fill", "bi-arrow-up-right-square", "bi-arrow-up-right-square-fill", "bi-arrow-up-square", "bi-arrow-up-square-fill", "bi-arrow-up-left", "bi-arrow-up-right", "bi-arrow-up-short", "bi-arrows-angle-contract", "bi-arrows-angle-expand", "bi-arrows-collapse", "bi-arrows-expand", "bi-arrows-fullscreen", "bi-arrows-move", "bi-aspect-ratio", "bi-aspect-ratio-fill", "bi-asterisk", "bi-at", "bi-award", "bi-award-fill", "bi-back", "bi-backspace", "bi-backspace-fill", "bi-backspace-reverse", "bi-backspace-reverse-fill", "bi-badge-3d", "bi-badge-3d-fill", "bi-badge-4k", "bi-badge-4k-fill", "bi-badge-8k", "bi-badge-8k-fill", "bi-badge-ad", "bi-badge-ad-fill", "bi-badge-ar", "bi-badge-ar-fill", "bi-badge-cc", "bi-badge-cc-fill", "bi-badge-hd", "bi-badge-hd-fill", "bi-badge-tm", "bi-badge-tm-fill", "bi-badge-vo", "bi-badge-vo-fill", "bi-badge-vr", "bi-badge-vr-fill", "bi-badge-wc", "bi-badge-wc-fill", "bi-bag", "bi-bag-check", "bi-bag-check-fill", "bi-bag-dash", "bi-bag-dash-fill", "bi-bag-fill", "bi-bag-plus", "bi-bag-plus-fill", "bi-bag-x", "bi-bag-x-fill", "bi-bank", "bi-bank2", "bi-bar-chart", "bi-bar-chart-fill", "bi-bar-chart-line", "bi-bar-chart-line-fill", "bi-bar-chart-steps", "bi-basket", "bi-basket-fill", "bi-basket2", "bi-basket2-fill", "bi-basket3", "bi-basket3-fill", "bi-battery", "bi-battery-charging", "bi-battery-full", "bi-battery-half", "bi-bell", "bi-bell-fill", "bi-bell-slash", "bi-bell-slash-fill", "bi-bezier", "bi-bezier2", "bi-bicycle", "bi-binoculars", "bi-binoculars-fill", "bi-blockquote-left", "bi-blockquote-right", "bi-book", "bi-book-fill", "bi-book-half", "bi-bookmark", "bi-bookmark-check", "bi-bookmark-check-fill", "bi-bookmark-dash", "bi-bookmark-dash-fill", "bi-bookmark-fill", "bi-bookmark-heart", "bi-bookmark-heart-fill", "bi-bookmark-plus", "bi-bookmark-plus-fill", "bi-bookmark-star", "bi-bookmark-star-fill", "bi-bookmark-x", "bi-bookmark-x-fill", "bi-bookmarks", "bi-bookmarks-fill", "bi-bookshelf", "bi-bootstrap", "bi-bootstrap-fill", "bi-bootstrap-reboot", "bi-border", "bi-border-all", "bi-border-bottom", "bi-border-center", "bi-border-inner", "bi-border-left", "bi-border-middle", "bi-border-outer", "bi-border-right", "bi-border-style", "bi-border-top", "bi-border-width", "bi-bounding-box", "bi-bounding-box-circles", "bi-box", "bi-box-arrow-down-left", "bi-box-arrow-down-right", "bi-box-arrow-down", "bi-box-arrow-in-down", "bi-box-arrow-in-down-left", "bi-box-arrow-in-down-right", "bi-box-arrow-in-left", "bi-box-arrow-in-right", "bi-box-arrow-in-up", "bi-box-arrow-in-up-left", "bi-box-arrow-in-up-right", "bi-box-arrow-left", "bi-box-arrow-right", "bi-box-arrow-up", "bi-box-arrow-up-left", "bi-box-arrow-up-right", "bi-box-seam", "bi-braces", "bi-bricks", "bi-briefcase", "bi-briefcase-fill", "bi-brightness-alt-high", "bi-brightness-alt-high-fill", "bi-brightness-alt-low", "bi-brightness-alt-low-fill", "bi-brightness-high", "bi-brightness-high-fill", "bi-brightness-low", "bi-brightness-low-fill", "bi-broadcast", "bi-broadcast-pin", "bi-brush", "bi-brush-fill", "bi-bucket", "bi-bucket-fill", "bi-bug", "bi-bug-fill", "bi-building", "bi-bullseye", "bi-calculator", "bi-calculator-fill", "bi-calendar", "bi-calendar-check", "bi-calendar-check-fill", "bi-calendar-date", "bi-calendar-date-fill", "bi-calendar-day", "bi-calendar-day-fill", "bi-calendar-event", "bi-calendar-event-fill", "bi-calendar-fill", "bi-calendar-minus", "bi-calendar-minus-fill", "bi-calendar-month", "bi-calendar-month-fill", "bi-calendar-plus", "bi-calendar-plus-fill", "bi-calendar-range", "bi-calendar-range-fill", "bi-calendar-week", "bi-calendar-week-fill", "bi-calendar-x", "bi-calendar-x-fill", "bi-calendar2", "bi-calendar2-check", "bi-calendar2-check-fill", "bi-calendar2-date", "bi-calendar2-date-fill", "bi-calendar2-day", "bi-calendar2-day-fill", "bi-calendar2-event", "bi-calendar2-event-fill", "bi-calendar2-fill", "bi-calendar2-minus", "bi-calendar2-minus-fill", "bi-calendar2-month", "bi-calendar2-month-fill", "bi-calendar2-plus", "bi-calendar2-plus-fill", "bi-calendar2-range", "bi-calendar2-range-fill", "bi-calendar2-week", "bi-calendar2-week-fill", "bi-calendar2-x", "bi-calendar2-x-fill", "bi-calendar3", "bi-calendar3-event", "bi-calendar3-event-fill", "bi-calendar3-fill", "bi-calendar3-range", "bi-calendar3-range-fill", "bi-calendar3-week", "bi-calendar3-week-fill", "bi-calendar4", "bi-calendar4-event", "bi-calendar4-range", "bi-calendar4-week", "bi-camera", "bi-camera2", "bi-camera-fill", "bi-camera-reels", "bi-camera-reels-fill", "bi-camera-video", "bi-camera-video-fill", "bi-camera-video-off", "bi-camera-video-off-fill", "bi-capslock", "bi-capslock-fill", "bi-card-checklist", "bi-card-heading", "bi-card-image", "bi-card-list", "bi-card-text", "bi-caret-down", "bi-caret-down-fill", "bi-caret-down-square", "bi-caret-down-square-fill", "bi-caret-left", "bi-caret-left-fill", "bi-caret-left-square", "bi-caret-left-square-fill", "bi-caret-right", "bi-caret-right-fill", "bi-caret-right-square", "bi-caret-right-square-fill", "bi-caret-up", "bi-caret-up-fill", "bi-caret-up-square", "bi-caret-up-square-fill", "bi-cart", "bi-cart-check", "bi-cart-check-fill", "bi-cart-dash", "bi-cart-dash-fill", "bi-cart-fill", "bi-cart-plus", "bi-cart-plus-fill", "bi-cart-x", "bi-cart-x-fill", "bi-cart2", "bi-cart3", "bi-cart4", "bi-cash", "bi-cash-coin", "bi-cash-stack", "bi-cast", "bi-chat", "bi-chat-dots", "bi-chat-dots-fill", "bi-chat-fill", "bi-chat-left", "bi-chat-left-dots", "bi-chat-left-dots-fill", "bi-chat-left-fill", "bi-chat-left-quote", "bi-chat-left-quote-fill", "bi-chat-left-text", "bi-chat-left-text-fill", "bi-chat-quote", "bi-chat-quote-fill", "bi-chat-right", "bi-chat-right-dots", "bi-chat-right-dots-fill", "bi-chat-right-fill", "bi-chat-right-quote", "bi-chat-right-quote-fill", "bi-chat-right-text", "bi-chat-right-text-fill", "bi-chat-square", "bi-chat-square-dots", "bi-chat-square-dots-fill", "bi-chat-square-fill", "bi-chat-square-quote", "bi-chat-square-quote-fill", "bi-chat-square-text", "bi-chat-square-text-fill", "bi-chat-text", "bi-chat-text-fill", "bi-check", "bi-check-all", "bi-check-circle", "bi-check-circle-fill", "bi-check-lg", "bi-check-square", "bi-check-square-fill", "bi-check2", "bi-check2-all", "bi-check2-circle", "bi-check2-square", "bi-chevron-bar-contract", "bi-chevron-bar-down", "bi-chevron-bar-expand", "bi-chevron-bar-left", "bi-chevron-bar-right", "bi-chevron-bar-up", "bi-chevron-compact-down", "bi-chevron-compact-left", "bi-chevron-compact-right", "bi-chevron-compact-up", "bi-chevron-contract", "bi-chevron-double-down", "bi-chevron-double-left", "bi-chevron-double-right", "bi-chevron-double-up", "bi-chevron-down", "bi-chevron-expand", "bi-chevron-left", "bi-chevron-right", "bi-chevron-up", "bi-circle", "bi-circle-fill", "bi-circle-half", "bi-slash-circle", "bi-circle-square", "bi-clipboard", "bi-clipboard-check", "bi-clipboard-data", "bi-clipboard-minus", "bi-clipboard-plus", "bi-clipboard-x", "bi-clock", "bi-clock-fill", "bi-clock-history", "bi-cloud", "bi-cloud-arrow-down", "bi-cloud-arrow-down-fill", "bi-cloud-arrow-up", "bi-cloud-arrow-up-fill", "bi-cloud-check", "bi-cloud-check-fill", "bi-cloud-download", "bi-cloud-download-fill", "bi-cloud-drizzle", "bi-cloud-drizzle-fill", "bi-cloud-fill", "bi-cloud-fog", "bi-cloud-fog-fill", "bi-cloud-fog2", "bi-cloud-fog2-fill", "bi-cloud-hail", "bi-cloud-hail-fill", "bi-cloud-haze", "bi-cloud-haze-1", "bi-cloud-haze-fill", "bi-cloud-haze2-fill", "bi-cloud-lightning", "bi-cloud-lightning-fill", "bi-cloud-lightning-rain", "bi-cloud-lightning-rain-fill", "bi-cloud-minus", "bi-cloud-minus-fill", "bi-cloud-moon", "bi-cloud-moon-fill", "bi-cloud-plus", "bi-cloud-plus-fill", "bi-cloud-rain", "bi-cloud-rain-fill", "bi-cloud-rain-heavy", "bi-cloud-rain-heavy-fill", "bi-cloud-slash", "bi-cloud-slash-fill", "bi-cloud-sleet", "bi-cloud-sleet-fill", "bi-cloud-snow", "bi-cloud-snow-fill", "bi-cloud-sun", "bi-cloud-sun-fill", "bi-cloud-upload", "bi-cloud-upload-fill", "bi-clouds", "bi-clouds-fill", "bi-cloudy", "bi-cloudy-fill", "bi-code", "bi-code-slash", "bi-code-square", "bi-coin", "bi-collection", "bi-collection-fill", "bi-collection-play", "bi-collection-play-fill", "bi-columns", "bi-columns-gap", "bi-command", "bi-compass", "bi-compass-fill", "bi-cone", "bi-cone-striped", "bi-controller", "bi-cpu", "bi-cpu-fill", "bi-credit-card", "bi-credit-card-2-back", "bi-credit-card-2-back-fill", "bi-credit-card-2-front", "bi-credit-card-2-front-fill", "bi-credit-card-fill", "bi-crop", "bi-cup", "bi-cup-fill", "bi-cup-straw", "bi-currency-bitcoin", "bi-currency-dollar", "bi-currency-euro", "bi-currency-exchange", "bi-currency-pound", "bi-currency-yen", "bi-cursor", "bi-cursor-fill", "bi-cursor-text", "bi-dash", "bi-dash-circle", "bi-dash-circle-dotted", "bi-dash-circle-fill", "bi-dash-lg", "bi-dash-square", "bi-dash-square-dotted", "bi-dash-square-fill", "bi-diagram-2", "bi-diagram-2-fill", "bi-diagram-3", "bi-diagram-3-fill", "bi-diamond", "bi-diamond-fill", "bi-diamond-half", "bi-dice-1", "bi-dice-1-fill", "bi-dice-2", "bi-dice-2-fill", "bi-dice-3", "bi-dice-3-fill", "bi-dice-4", "bi-dice-4-fill", "bi-dice-5", "bi-dice-5-fill", "bi-dice-6", "bi-dice-6-fill", "bi-disc", "bi-disc-fill", "bi-discord", "bi-display", "bi-display-fill", "bi-distribute-horizontal", "bi-distribute-vertical", "bi-door-closed", "bi-door-closed-fill", "bi-door-open", "bi-door-open-fill", "bi-dot", "bi-download", "bi-droplet", "bi-droplet-fill", "bi-droplet-half", "bi-earbuds", "bi-easel", "bi-easel-fill", "bi-egg", "bi-egg-fill", "bi-egg-fried", "bi-eject", "bi-eject-fill", "bi-emoji-angry", "bi-emoji-angry-fill", "bi-emoji-dizzy", "bi-emoji-dizzy-fill", "bi-emoji-expressionless", "bi-emoji-expressionless-fill", "bi-emoji-frown", "bi-emoji-frown-fill", "bi-emoji-heart-eyes", "bi-emoji-heart-eyes-fill", "bi-emoji-laughing", "bi-emoji-laughing-fill", "bi-emoji-neutral", "bi-emoji-neutral-fill", "bi-emoji-smile", "bi-emoji-smile-fill", "bi-emoji-smile-upside-down", "bi-emoji-smile-upside-down-fill", "bi-emoji-sunglasses", "bi-emoji-sunglasses-fill", "bi-emoji-wink", "bi-emoji-wink-fill", "bi-envelope", "bi-envelope-fill", "bi-envelope-open", "bi-envelope-open-fill", "bi-eraser", "bi-eraser-fill", "bi-exclamation", "bi-exclamation-circle", "bi-exclamation-circle-fill", "bi-exclamation-diamond", "bi-exclamation-diamond-fill", "bi-exclamation-lg", "bi-exclamation-octagon", "bi-exclamation-octagon-fill", "bi-exclamation-square", "bi-exclamation-square-fill", "bi-exclamation-triangle", "bi-exclamation-triangle-fill", "bi-exclude", "bi-eye", "bi-eye-fill", "bi-eye-slash", "bi-eye-slash-fill", "bi-eyedropper", "bi-eyeglasses", "bi-facebook", "bi-file", "bi-file-arrow-down", "bi-file-arrow-down-fill", "bi-file-arrow-up", "bi-file-arrow-up-fill", "bi-file-bar-graph", "bi-file-bar-graph-fill", "bi-file-binary", "bi-file-binary-fill", "bi-file-break", "bi-file-break-fill", "bi-file-check", "bi-file-check-fill", "bi-file-code", "bi-file-code-fill", "bi-file-diff", "bi-file-diff-fill", "bi-file-earmark", "bi-file-earmark-arrow-down", "bi-file-earmark-arrow-down-fill", "bi-file-earmark-arrow-up", "bi-file-earmark-arrow-up-fill", "bi-file-earmark-bar-graph", "bi-file-earmark-bar-graph-fill", "bi-file-earmark-binary", "bi-file-earmark-binary-fill", "bi-file-earmark-break", "bi-file-earmark-break-fill", "bi-file-earmark-check", "bi-file-earmark-check-fill", "bi-file-earmark-code", "bi-file-earmark-code-fill", "bi-file-earmark-diff", "bi-file-earmark-diff-fill", "bi-file-earmark-easel", "bi-file-earmark-easel-fill", "bi-file-earmark-excel", "bi-file-earmark-excel-fill", "bi-file-earmark-fill", "bi-file-earmark-font", "bi-file-earmark-font-fill", "bi-file-earmark-image", "bi-file-earmark-image-fill", "bi-file-earmark-lock", "bi-file-earmark-lock-fill", "bi-file-earmark-lock2", "bi-file-earmark-lock2-fill", "bi-file-earmark-medical", "bi-file-earmark-medical-fill", "bi-file-earmark-minus", "bi-file-earmark-minus-fill", "bi-file-earmark-music", "bi-file-earmark-music-fill", "bi-file-earmark-pdf", "bi-file-earmark-pdf-fill", "bi-file-earmark-person", "bi-file-earmark-person-fill", "bi-file-earmark-play", "bi-file-earmark-play-fill", "bi-file-earmark-plus", "bi-file-earmark-plus-fill", "bi-file-earmark-post", "bi-file-earmark-post-fill", "bi-file-earmark-ppt", "bi-file-earmark-ppt-fill", "bi-file-earmark-richtext", "bi-file-earmark-richtext-fill", "bi-file-earmark-ruled", "bi-file-earmark-ruled-fill", "bi-file-earmark-slides", "bi-file-earmark-slides-fill", "bi-file-earmark-spreadsheet", "bi-file-earmark-spreadsheet-fill", "bi-file-earmark-text", "bi-file-earmark-text-fill", "bi-file-earmark-word", "bi-file-earmark-word-fill", "bi-file-earmark-x", "bi-file-earmark-x-fill", "bi-file-earmark-zip", "bi-file-earmark-zip-fill", "bi-file-easel", "bi-file-easel-fill", "bi-file-excel", "bi-file-excel-fill", "bi-file-fill", "bi-file-font", "bi-file-font-fill", "bi-file-image", "bi-file-image-fill", "bi-file-lock", "bi-file-lock-fill", "bi-file-lock2", "bi-file-lock2-fill", "bi-file-medical", "bi-file-medical-fill", "bi-file-minus", "bi-file-minus-fill", "bi-file-music", "bi-file-music-fill", "bi-file-pdf", "bi-file-pdf-fill", "bi-file-person", "bi-file-person-fill", "bi-file-play", "bi-file-play-fill", "bi-file-plus", "bi-file-plus-fill", "bi-file-post", "bi-file-post-fill", "bi-file-ppt", "bi-file-ppt-fill", "bi-file-richtext", "bi-file-richtext-fill", "bi-file-ruled", "bi-file-ruled-fill", "bi-file-slides", "bi-file-slides-fill", "bi-file-spreadsheet", "bi-file-spreadsheet-fill", "bi-file-text", "bi-file-text-fill", "bi-file-word", "bi-file-word-fill", "bi-file-x", "bi-file-x-fill", "bi-file-zip", "bi-file-zip-fill", "bi-files", "bi-files-alt", "bi-film", "bi-filter", "bi-filter-circle", "bi-filter-circle-fill", "bi-filter-left", "bi-filter-right", "bi-filter-square", "bi-filter-square-fill", "bi-flag", "bi-flag-fill", "bi-flower1", "bi-flower2", "bi-flower3", "bi-folder", "bi-folder-check", "bi-folder-fill", "bi-folder-minus", "bi-folder-plus", "bi-folder-symlink", "bi-folder-symlink-fill", "bi-folder-x", "bi-folder2", "bi-folder2-open", "bi-fonts", "bi-forward", "bi-forward-fill", "bi-front", "bi-fullscreen", "bi-fullscreen-exit", "bi-funnel", "bi-funnel-fill", "bi-gear", "bi-gear-fill", "bi-gear-wide", "bi-gear-wide-connected", "bi-gem", "bi-gender-ambiguous", "bi-gender-female", "bi-gender-male", "bi-gender-trans", "bi-geo", "bi-geo-alt", "bi-geo-alt-fill", "bi-geo-fill", "bi-gift", "bi-gift-fill", "bi-github", "bi-globe", "bi-globe2", "bi-google", "bi-graph-down", "bi-graph-up", "bi-grid", "bi-grid-1x2", "bi-grid-1x2-fill", "bi-grid-3x2", "bi-grid-3x2-gap", "bi-grid-3x2-gap-fill", "bi-grid-3x3", "bi-grid-3x3-gap", "bi-grid-3x3-gap-fill", "bi-grid-fill", "bi-grip-horizontal", "bi-grip-vertical", "bi-hammer", "bi-hand-index", "bi-hand-index-fill", "bi-hand-index-thumb", "bi-hand-index-thumb-fill", "bi-hand-thumbs-down", "bi-hand-thumbs-down-fill", "bi-hand-thumbs-up", "bi-hand-thumbs-up-fill", "bi-handbag", "bi-handbag-fill", "bi-hash", "bi-hdd", "bi-hdd-fill", "bi-hdd-network", "bi-hdd-network-fill", "bi-hdd-rack", "bi-hdd-rack-fill", "bi-hdd-stack", "bi-hdd-stack-fill", "bi-headphones", "bi-headset", "bi-headset-vr", "bi-heart", "bi-heart-fill", "bi-heart-half", "bi-heptagon", "bi-heptagon-fill", "bi-heptagon-half", "bi-hexagon", "bi-hexagon-fill", "bi-hexagon-half", "bi-hourglass", "bi-hourglass-bottom", "bi-hourglass-split", "bi-hourglass-top", "bi-house", "bi-house-door", "bi-house-door-fill", "bi-house-fill", "bi-hr", "bi-hurricane", "bi-image", "bi-image-alt", "bi-image-fill", "bi-images", "bi-inbox", "bi-inbox-fill", "bi-inboxes-fill", "bi-inboxes", "bi-info", "bi-info-circle", "bi-info-circle-fill", "bi-info-lg", "bi-info-square", "bi-info-square-fill", "bi-input-cursor", "bi-input-cursor-text", "bi-instagram", "bi-intersect", "bi-journal", "bi-journal-album", "bi-journal-arrow-down", "bi-journal-arrow-up", "bi-journal-bookmark", "bi-journal-bookmark-fill", "bi-journal-check", "bi-journal-code", "bi-journal-medical", "bi-journal-minus", "bi-journal-plus", "bi-journal-richtext", "bi-journal-text", "bi-journal-x", "bi-journals", "bi-joystick", "bi-justify", "bi-justify-left", "bi-justify-right", "bi-kanban", "bi-kanban-fill", "bi-key", "bi-key-fill", "bi-keyboard", "bi-keyboard-fill", "bi-ladder", "bi-lamp", "bi-lamp-fill", "bi-laptop", "bi-laptop-fill", "bi-layer-backward", "bi-layer-forward", "bi-layers", "bi-layers-fill", "bi-layers-half", "bi-layout-sidebar", "bi-layout-sidebar-inset-reverse", "bi-layout-sidebar-inset", "bi-layout-sidebar-reverse", "bi-layout-split", "bi-layout-text-sidebar", "bi-layout-text-sidebar-reverse", "bi-layout-text-window", "bi-layout-text-window-reverse", "bi-layout-three-columns", "bi-layout-wtf", "bi-life-preserver", "bi-lightbulb", "bi-lightbulb-fill", "bi-lightbulb-off", "bi-lightbulb-off-fill", "bi-lightning", "bi-lightning-charge", "bi-lightning-charge-fill", "bi-lightning-fill", "bi-link", "bi-link-45deg", "bi-linkedin", "bi-list", "bi-list-check", "bi-list-nested", "bi-list-ol", "bi-list-stars", "bi-list-task", "bi-list-ul", "bi-lock", "bi-lock-fill", "bi-mailbox", "bi-mailbox2", "bi-map", "bi-map-fill", "bi-markdown", "bi-markdown-fill", "bi-mask", "bi-mastodon", "bi-megaphone", "bi-megaphone-fill", "bi-menu-app", "bi-menu-app-fill", "bi-menu-button", "bi-menu-button-fill", "bi-menu-button-wide", "bi-menu-button-wide-fill", "bi-menu-down", "bi-menu-up", "bi-messenger", "bi-mic", "bi-mic-fill", "bi-mic-mute", "bi-mic-mute-fill", "bi-minecart", "bi-minecart-loaded", "bi-moisture", "bi-moon", "bi-moon-fill", "bi-moon-stars", "bi-moon-stars-fill", "bi-mouse", "bi-mouse-fill", "bi-mouse2", "bi-mouse2-fill", "bi-mouse3", "bi-mouse3-fill", "bi-music-note", "bi-music-note-beamed", "bi-music-note-list", "bi-music-player", "bi-music-player-fill", "bi-newspaper", "bi-node-minus", "bi-node-minus-fill", "bi-node-plus", "bi-node-plus-fill", "bi-nut", "bi-nut-fill", "bi-octagon", "bi-octagon-fill", "bi-octagon-half", "bi-option", "bi-outlet", "bi-paint-bucket", "bi-palette", "bi-palette-fill", "bi-palette2", "bi-paperclip", "bi-paragraph", "bi-patch-check", "bi-patch-check-fill", "bi-patch-exclamation", "bi-patch-exclamation-fill", "bi-patch-minus", "bi-patch-minus-fill", "bi-patch-plus", "bi-patch-plus-fill", "bi-patch-question", "bi-patch-question-fill", "bi-pause", "bi-pause-btn", "bi-pause-btn-fill", "bi-pause-circle", "bi-pause-circle-fill", "bi-pause-fill", "bi-peace", "bi-peace-fill", "bi-pen", "bi-pen-fill", "bi-pencil", "bi-pencil-fill", "bi-pencil-square", "bi-pentagon", "bi-pentagon-fill", "bi-pentagon-half", "bi-people", "bi-person-circle", "bi-people-fill", "bi-percent", "bi-person", "bi-person-badge", "bi-person-badge-fill", "bi-person-bounding-box", "bi-person-check", "bi-person-check-fill", "bi-person-dash", "bi-person-dash-fill", "bi-person-fill", "bi-person-lines-fill", "bi-person-plus", "bi-person-plus-fill", "bi-person-square", "bi-person-x", "bi-person-x-fill", "bi-phone", "bi-phone-fill", "bi-phone-landscape", "bi-phone-landscape-fill", "bi-phone-vibrate", "bi-phone-vibrate-fill", "bi-pie-chart", "bi-pie-chart-fill", "bi-piggy-bank", "bi-piggy-bank-fill", "bi-pin", "bi-pin-angle", "bi-pin-angle-fill", "bi-pin-fill", "bi-pin-map", "bi-pin-map-fill", "bi-pip", "bi-pip-fill", "bi-play", "bi-play-btn", "bi-play-btn-fill", "bi-play-circle", "bi-play-circle-fill", "bi-play-fill", "bi-plug", "bi-plug-fill", "bi-plus", "bi-plus-circle", "bi-plus-circle-dotted", "bi-plus-circle-fill", "bi-plus-lg", "bi-plus-square", "bi-plus-square-dotted", "bi-plus-square-fill", "bi-power", "bi-printer", "bi-printer-fill", "bi-puzzle", "bi-puzzle-fill", "bi-question", "bi-question-circle", "bi-question-diamond", "bi-question-diamond-fill", "bi-question-circle-fill", "bi-question-lg", "bi-question-octagon", "bi-question-octagon-fill", "bi-question-square", "bi-question-square-fill", "bi-rainbow", "bi-receipt", "bi-receipt-cutoff", "bi-reception-0", "bi-reception-1", "bi-reception-2", "bi-reception-3", "bi-reception-4", "bi-record", "bi-record-btn", "bi-record-btn-fill", "bi-record-circle", "bi-record-circle-fill", "bi-record-fill", "bi-record2", "bi-record2-fill", "bi-recycle", "bi-reddit", "bi-reply", "bi-reply-all", "bi-reply-all-fill", "bi-reply-fill", "bi-rss", "bi-rss-fill", "bi-rulers", "bi-safe", "bi-safe-fill", "bi-safe2", "bi-safe2-fill", "bi-save", "bi-save-fill", "bi-save2", "bi-save2-fill", "bi-scissors", "bi-screwdriver", "bi-sd-card", "bi-sd-card-fill", "bi-search", "bi-segmented-nav", "bi-server", "bi-share", "bi-share-fill", "bi-shield", "bi-shield-check", "bi-shield-exclamation", "bi-shield-fill", "bi-shield-fill-check", "bi-shield-fill-exclamation", "bi-shield-fill-minus", "bi-shield-fill-plus", "bi-shield-fill-x", "bi-shield-lock", "bi-shield-lock-fill", "bi-shield-minus", "bi-shield-plus", "bi-shield-shaded", "bi-shield-slash", "bi-shield-slash-fill", "bi-shield-x", "bi-shift", "bi-shift-fill", "bi-shop", "bi-shop-window", "bi-shuffle", "bi-signpost", "bi-signpost-2", "bi-signpost-2-fill", "bi-signpost-fill", "bi-signpost-split", "bi-signpost-split-fill", "bi-sim", "bi-sim-fill", "bi-skip-backward", "bi-skip-backward-btn", "bi-skip-backward-btn-fill", "bi-skip-backward-circle", "bi-skip-backward-circle-fill", "bi-skip-backward-fill", "bi-skip-end", "bi-skip-end-btn", "bi-skip-end-btn-fill", "bi-skip-end-circle", "bi-skip-end-circle-fill", "bi-skip-end-fill", "bi-skip-forward", "bi-skip-forward-btn", "bi-skip-forward-btn-fill", "bi-skip-forward-circle", "bi-skip-forward-circle-fill", "bi-skip-forward-fill", "bi-skip-start", "bi-skip-start-btn", "bi-skip-start-btn-fill", "bi-skip-start-circle", "bi-skip-start-circle-fill", "bi-skip-start-fill", "bi-skype", "bi-slack", "bi-slash", "bi-slash-circle-fill", "bi-slash-lg", "bi-slash-square", "bi-slash-square-fill", "bi-sliders", "bi-smartwatch", "bi-snow", "bi-snow2", "bi-snow3", "bi-sort-alpha-down", "bi-sort-alpha-down-alt", "bi-sort-alpha-up", "bi-sort-alpha-up-alt", "bi-sort-down", "bi-sort-down-alt", "bi-sort-numeric-down", "bi-sort-numeric-down-alt", "bi-sort-numeric-up", "bi-sort-numeric-up-alt", "bi-sort-up", "bi-sort-up-alt", "bi-soundwave", "bi-speaker", "bi-speaker-fill", "bi-speedometer", "bi-speedometer2", "bi-spellcheck", "bi-square", "bi-square-fill", "bi-square-half", "bi-stack", "bi-star", "bi-star-fill", "bi-star-half", "bi-stars", "bi-stickies", "bi-stickies-fill", "bi-sticky", "bi-sticky-fill", "bi-stop", "bi-stop-btn", "bi-stop-btn-fill", "bi-stop-circle", "bi-stop-circle-fill", "bi-stop-fill", "bi-stoplights", "bi-stoplights-fill", "bi-stopwatch", "bi-stopwatch-fill", "bi-subtract", "bi-suit-club", "bi-suit-club-fill", "bi-suit-diamond", "bi-suit-diamond-fill", "bi-suit-heart", "bi-suit-heart-fill", "bi-suit-spade", "bi-suit-spade-fill", "bi-sun", "bi-sun-fill", "bi-sunglasses", "bi-sunrise", "bi-sunrise-fill", "bi-sunset", "bi-sunset-fill", "bi-symmetry-horizontal", "bi-symmetry-vertical", "bi-table", "bi-tablet", "bi-tablet-fill", "bi-tablet-landscape", "bi-tablet-landscape-fill", "bi-tag", "bi-tag-fill", "bi-tags", "bi-tags-fill", "bi-telegram", "bi-telephone", "bi-telephone-fill", "bi-telephone-forward", "bi-telephone-forward-fill", "bi-telephone-inbound", "bi-telephone-inbound-fill", "bi-telephone-minus", "bi-telephone-minus-fill", "bi-telephone-outbound", "bi-telephone-outbound-fill", "bi-telephone-plus", "bi-telephone-plus-fill", "bi-telephone-x", "bi-telephone-x-fill", "bi-terminal", "bi-terminal-fill", "bi-text-center", "bi-text-indent-left", "bi-text-indent-right", "bi-text-left", "bi-text-paragraph", "bi-text-right", "bi-textarea", "bi-textarea-resize", "bi-textarea-t", "bi-thermometer", "bi-thermometer-half", "bi-thermometer-high", "bi-thermometer-low", "bi-thermometer-snow", "bi-thermometer-sun", "bi-three-dots", "bi-three-dots-vertical", "bi-toggle-off", "bi-toggle-on", "bi-toggle2-off", "bi-toggle2-on", "bi-toggles", "bi-toggles2", "bi-tools", "bi-tornado", "bi-translate", "bi-trash", "bi-trash-fill", "bi-trash2", "bi-trash2-fill", "bi-tree", "bi-tree-fill", "bi-triangle", "bi-triangle-fill", "bi-triangle-half", "bi-trophy", "bi-trophy-fill", "bi-tropical-storm", "bi-truck", "bi-truck-flatbed", "bi-tsunami", "bi-tv", "bi-tv-fill", "bi-twitch", "bi-twitter", "bi-type", "bi-type-bold", "bi-type-h1", "bi-type-h2", "bi-type-h3", "bi-type-italic", "bi-type-strikethrough", "bi-type-underline", "bi-ui-checks", "bi-ui-checks-grid", "bi-ui-radios", "bi-ui-radios-grid", "bi-umbrella", "bi-umbrella-fill", "bi-union", "bi-unlock", "bi-unlock-fill", "bi-upc", "bi-upc-scan", "bi-upload", "bi-vector-pen", "bi-view-list", "bi-view-stacked", "bi-vinyl", "bi-vinyl-fill", "bi-voicemail", "bi-volume-down", "bi-volume-down-fill", "bi-volume-mute", "bi-volume-mute-fill", "bi-volume-off", "bi-volume-off-fill", "bi-volume-up", "bi-volume-up-fill", "bi-vr", "bi-wallet", "bi-wallet-fill", "bi-wallet2", "bi-watch", "bi-water", "bi-whatsapp", "bi-wifi", "bi-wifi-1", "bi-wifi-2", "bi-wifi-off", "bi-wind", "bi-window", "bi-window-dock", "bi-window-sidebar", "bi-wrench", "bi-x", "bi-x-circle", "bi-x-circle-fill", "bi-x-diamond", "bi-x-diamond-fill", "bi-x-lg", "bi-x-octagon", "bi-x-octagon-fill", "bi-x-square", "bi-x-square-fill", "bi-youtube", "bi-zoom-in", "bi-zoom-out");

    return $AllIconList;
}

function RolesName($data){

    $data = str_replace('language.index','Dil Listeleme',$data);
    $data = str_replace('language.store','Dil Güncelleme',$data);
    $data = str_replace('language.destroy','Dil Silme',$data);
    $data = str_replace('contents.index','Sayfa Listeleme',$data);
    $data = str_replace('contents.create','Sayfa Oluşturma',$data);
    $data = str_replace('contents.store','Sayfa Güncelleme',$data);
    $data = str_replace('contents.show','Sayfa Görüntüleme',$data);
    $data = str_replace('contents.destroy','Sayfa Silme',$data);
    $data = str_replace('menu.index','Menü Listeleme',$data);
    $data = str_replace('menu.create','Menü Oluşturma',$data);
    $data = str_replace('menu.store','Menü Güncelleme',$data);
    $data = str_replace('menu.show','Menü Görüntüleme',$data);
    $data = str_replace('menu.edit','Menü Editleme',$data);
    $data = str_replace('menu.destroy','Menü Silme',$data);
    $data = str_replace('slider.index','Slider Listeleme',$data);
    $data = str_replace('slider.create','Slider Oluşturma',$data);
    $data = str_replace('slider.store','Slider Güncelleme',$data);
    $data = str_replace('slider.show','Slider Görüntüleme',$data);
    $data = str_replace('slider.destroy','Slider Silme',$data);
    $data = str_replace('site-settings.index','Site Ayarları Listeleme',$data);
    $data = str_replace('site-settings.store','Site Ayarları Güncelleme',$data);
    $data = str_replace('social-media.store','Sosyal Medya Güncelleme',$data);
    $data = str_replace('social-media.update','Sosyal Medya Görüntüleme',$data);
    $data = str_replace('social-media.destroy','Sosyal Medya Silme',$data);
    $data = str_replace('form-builder.index','Form Listeleme',$data);
    $data = str_replace('form-builder.create','Form Oluşturma',$data);
    $data = str_replace('form-builder.store','Form Güncelleme',$data);
    $data = str_replace('form-builder.show','Form Görüntüleme',$data);
    $data = str_replace('form-builder.destroy','Form Silme',$data);
    $data = str_replace('blok-management.index','Blok Yönetimi Listeleme',$data);
    $data = str_replace('blok-management.create','Blok Yönetimi Oluşturma',$data);
    $data = str_replace('blok-management.store','Blok Yönetimi Güncelleme',$data);
    $data = str_replace('blok-management.show','Blok Yönetimi Görüntüleme',$data);
    $data = str_replace('blok-management.destroy','Blok Yönetimi Silme',$data);
    $data = str_replace('users.index','Kullanıcıları Listeleme',$data);
    $data = str_replace('users.create','Kullanıcı Oluşturma',$data);
    $data = str_replace('users.store','Kullanıcıları Güncelleme',$data);
    $data = str_replace('users.show','Kullanıcıları Görüntüleme',$data);
    $data = str_replace('users.destroy','Kullanıcı Silme',$data);
    $data = str_replace('permission.index','İzin Listesi Listeleme',$data);
    $data = str_replace('permission.create','İzin Listesi Oluşturma',$data);
    $data = str_replace('permission.store','İzin Listesi Güncelleme',$data);
    $data = str_replace('permission.show','İzin Listesi Görüntüleme',$data);
    $data = str_replace('gallery.index','Galeri Listeleme',$data);
    $data = str_replace('gallery.create','Galeri Oluşturma',$data);
    $data = str_replace('gallery.store','Galeri Güncelleme',$data);
    $data = str_replace('gallery.show','Galeri Görüntüleme',$data);
    $data = str_replace('gallery.destroy','Galeri Silme',$data);

    return $data;
}
function getCurrentUrlName(){
    $name = Illuminate\Support\Facades\Route::getCurrentRoute()->getName();
    $name = explode('.',$name);
    if(!empty($name[0])){
        return $name[0];
    }else{
        return "dashboard";
    }
}
function getFixedWord($colum,$lang){
     $word = \App\Models\fixed_language_word::where('lang_id',getLangId($lang))->where('code_name',$colum)->first();
     if(!empty($word->word)){
         return $word->word;
     }

}
function getSiteSetting($colum,$lang = null){
    $lang = \App\Models\Language::where('main_language',1)->first();
    $lang = $lang->id;

    $site_setting = \App\Models\site_settings::where('language_id',$lang)->where('status',1)->first();
    if(!empty($site_setting)){
        return $site_setting->$colum;
    }
}
function getAllSocial($lang=null){
    $lang = \App\Models\Language::where('main_language',1)->first();
    $lang = $lang->id;

    $site_setting = \App\Models\site_settings::where('language_id',$lang)->where('status',1)->first();
    $social_media = \App\Models\social_media::where('sitesettings_id',$site_setting->id)->get();

    return $social_media;
}
function getAllAddress(){
    $getAllAddress = array();
    $lang = \App\Models\Language::where('main_language',1)->first();
    $lang = $lang->id;

    $site_setting = \App\Models\site_settings::where('language_id',$lang)->where('status',1)->first();
    $address = \App\Models\Address::where('site_settings_id',$site_setting->id)->get();
    foreach($address as $a){
        $getAllAddress[]=$a->address;
    }
    return $getAllAddress;
}

function getAllPhone(){
    $getAllPhone = array();
    $lang = \App\Models\Language::where('main_language',1)->first();
    $lang = $lang->id;

    $site_setting = \App\Models\site_settings::where('language_id',$lang)->where('status',1)->first();
    $address = \App\Models\Address::where('site_settings_id',$site_setting->id)->get();
    foreach($address as $a){
        $getAllPhone[]=$a->gsm;
    }
    return $getAllPhone;
}
function getAllEmail(){
    $getAllEmail = array();
    $lang = \App\Models\Language::where('main_language',1)->first();
    $lang = $lang->id;

    $site_setting = \App\Models\site_settings::where('language_id',$lang)->where('status',1)->first();
    $address = \App\Models\Address::where('site_settings_id',$site_setting->id)->get();
    foreach($address as $a){
        $getAllEmail[]=$a->email;
    }
    return $getAllEmail;
}

function getAllOffice(){
    $lang = \App\Models\Language::where('main_language',1)->first();
    $lang = $lang->id;

    $site_setting = \App\Models\site_settings::where('language_id',$lang)->where('status',1)->first();
    $address = \App\Models\Address::where('site_settings_id',$site_setting->id)->get();

    return $address;
}

function langUrlControl($lang = null,$seo_url = null){
    $params = array(
        'lang'=>'',
        'seo_url'=>'',
    );

    if(empty($seo_url) && !empty($lang)){
        $language = Language::where('slug',$lang)->first();
        if(!empty($language)){
            $params['lang']=$lang;
            $params['seo_url'] = '/';
        }else{
            $main_language = Language::where('main_language',1)->first();
            $params['lang']=$main_language->slug;
            $params['seo_url'] = $lang;
        }

    }
    if(empty($seo_url) && empty($lang)){

        $main_language = Language::where('main_language',1)->first();
        $params['lang']=$main_language->slug;
        $params['seo_url'] = "/";

    }
    if(!empty($lang) && !empty($seo_url)){

        $params = array(
            'lang'=>$lang,
            'seo_url'=>$seo_url,
        );
    }

    return $params;
}
function getLangId($slug){
    $language = Language::where('slug',$slug)->where('status',1)->first();
    if(!empty($language->id)){
        return $language->id;
    }else{
        $main_language = Language::where('main_language',1)->first();
        return $main_language->id;
    }
}
function getLangName($id){
    $language = Language::where('id',$id)->where('status',1)->first();
    if(!empty($language->short_name)){
        return $language->short_name;
    }
}
function trchar_toupper($text)
{
    $search=array("ç","i","ı","ğ","ö","ş","ü");
    $replace=array("Ç","İ","I","Ğ","Ö","Ş","Ü");
    $text=str_replace($search,$replace,$text);
    $text=strtoupper($text);
    return $text;
}

function makeApiRequest($url, $apiToken,$data = null) {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiToken,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        return [
            'success' => false,
            'error' => $error
        ];
    }

    curl_close($ch);

    return [
        'success' => true,
        'data' => $response,
    ];
}
function OrderRefund($merchant_oid,$return_amount){
    $merchant_id = env('PAYTR_MERCHANT_ID');
    $merchant_key = env('PAYTR_MERCHANT_KEY');
    $merchant_salt = env('PAYTR_MERCHANT_SALT');
    #
    $merchant_oid   = $merchant_oid;
    #
    $return_amount  = $return_amount;

    $paytr_token=base64_encode(hash_hmac('sha256',$merchant_id.$merchant_oid.$return_amount.$merchant_salt,$merchant_key,true));

    $post_vals=array(
        'merchant_id'=>$merchant_id,
        'merchant_oid'=>$merchant_oid,
        'return_amount'=>$return_amount,
        'paytr_token'=>$paytr_token
    );

    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/iade");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1) ;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 90);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 90);

    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $result = @curl_exec($ch);

    if(curl_errno($ch))
    {
        echo curl_error($ch);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    $result=json_decode($result,1);



    if($result['status']=='success')
    {
        $new_order_refund = New OrderRefund();
        $new_order_refund->status = $result['status'];
        $new_order_refund->is_test = $result['is_test'];
        $new_order_refund->merchant_oid = $result['merchant_oid'];
        $new_order_refund->return_amount = $result['return_amount'];
        $new_order_refund->save();
    }

}

function getUpDiscountRate(){
    $package = \App\Models\Packages::where('status',1)->orderBy('discount_rate','desc')->first();
    return $package->discount_rate;
}

function getOrderCount($type = 1){
    if($type == 1){

        $order = \App\Models\Orders::where('customer_id',Auth::user()->id)->wherehas('orderProducts',function($query){
            $query->where('product_id','!=',5);
        })->count();
    }elseif($type == 2){
        $order = \App\Models\Orders::where('customer_id',Auth::user()->id)->wherehas('orderProducts',function($query){
            $query->where('product_type',2);
            $query->where('product_id','!=',5);
        })->count();
    }elseif($type == 3){
        $order = \App\Models\Orders::where('customer_id',Auth::user()->id)->wherehas('orderProducts',function($query){
            $query->where('product_type',1);
            $query->where('product_id','!=',5);
        })->count();
    }else{
        $order = 0;
    }

    return $order;
}
function getOrderStartDateDiff(){
    $date_dif = "0";
    $order = \App\Models\Orders::where('customer_id',Auth::user()->id)->wherehas('orderProducts',function($query){
        $query->where('product_type',2);
        $query->where('product_id','!=',5);
    })->get();
    foreach($order as $o){
        $start_date = $o->start_date;
        $finish_date = $o->finish_date;

        $start_timestamp = strtotime($start_date);
        $finish_timestamp = strtotime($finish_date);
        $time_difference = $finish_timestamp - $start_timestamp;
        $day_difference = $time_difference / (60 * 60 * 24);
        $date_dif += $day_difference;
    }
    $years = floor($date_dif / 365);
    $months = floor(($date_dif % 365) / 30);
    $days = $date_dif % 365 % 30;


    $result = '';

    if ($years > 0) {
        $result .= $years . " Yıl ";
    }
    if ($months > 0) {
        $result .= $months . " Ay ";
    }
    if ($days > 0 || $date_dif == 0) { // Gün sayısı 0 bile olsa bunu eklemek için
        $result .= $days . " Gün";
    }
    return $result;
}
function totalHallEntry(){
    $work_out_follow = \App\Models\WorkOutFollow::where('customer_id',\Illuminate\Support\Facades\Auth::user()->id)
        ->where('type',1)
        ->count();

    return $work_out_follow;
}
function getAddress($type){
    $address = \App\Models\CustomerAddress::where('customer_id',\Illuminate\Support\Facades\Auth::user()->id)
        ->where('address_type',$type)->first();

    return $address;
}
