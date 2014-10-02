<?php
    global $post;
    //uses post content as link, and title as link text
    echo '<h2 class="post-title"><a href="'. esc_url($post->post_content) . '">' . get_the_title() . '</a></h2>';
