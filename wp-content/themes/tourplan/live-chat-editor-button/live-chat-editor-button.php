<?php

add_shortcode('live-chat-button', 'live_chat_editor_button');
function live_chat_editor_button() {
    $button_html = '<div id="textLink" class="btn btn-primary">Live Chat</div>';
    return $button_html;
}