<div class="flex">
    <?php
    $btnClass = 'btn-anchor bg-cyan-500 text-white font-semibold cursor-pointer';

    $anchorPrev = anchor(current_url() . '?page=' . $pagination['prev_page'], 'Prev', ['class' => $btnClass]);
    $anchorNext = anchor(current_url() . '?page=' . $pagination['next_page'], 'Next', ['class' => $btnClass]);

    /** ----------- PRINT OUT -------------- */
    if ($pagination['prev_page'] != null) {
        echo $anchorPrev;
    }

    echo '<div class="px-2 flex items-center gap-3">';

    if ($pagination['prev_page'] != null) {
        echo "<span>{$pagination['prev_page']}</span>";
    }
    echo "<span class='text-purple-500 font-medium underline'>{$pagination['curent_page']}</span>";

    if ($pagination['next_page'] != null) {
        echo "<span>{$pagination['next_page']}</span>";
    }

    echo "</div>";

    if ($pagination['next_page'] != null) {
        echo $anchorNext;
    }
    ?>
</div>