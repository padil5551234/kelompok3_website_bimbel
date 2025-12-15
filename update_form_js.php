<?php

echo "Updating form with JavaScript enhancements...\n";

$formPath = __DIR__ . '/resources/views/admin/material/form.blade.php';

if (!file_exists($formPath)) {
    echo "❌ Form file not found\n";
    exit(1);
}

$content = file_get_contents($formPath);

// Add JavaScript for chapter number suggestions
$jsEnhancements = '
<script>
$(document).ready(function() {
    // Auto-suggest next chapter number when batch is selected
    $("#batch_id").on("change", function() {
        const batchId = $(this).val();
        if (batchId) {
            // Make AJAX call to get next chapter number
            $.get("/admin/material/next-chapter/" + batchId, function(data) {
                if (data.next_chapter) {
                    $("#chapter_number").attr("placeholder", "Next: " + data.next_chapter);
                    $("#chapter_number").attr("title", "Suggested: " + data.next_chapter);
                }
            }).fail(function() {
                // If AJAX fails, just use default placeholder
                $("#chapter_number").attr("placeholder", "1");
            });
        } else {
            $("#chapter_number").attr("placeholder", "1");
        }
    });
    
    // Show suggestion when chapter number field is focused
    $("#chapter_number").on("focus", function() {
        const batchId = $("#batch_id").val();
        const currentValue = $(this).val();
        
        if (!currentValue && batchId) {
            $.get("/admin/material/next-chapter/" + batchId, function(data) {
                if (data.next_chapter && !$("#chapter_number").val()) {
                    // Show temporary tooltip with suggestion
                    $(this).attr("title", "Suggested: " + data.next_chapter);
                }
            }.bind(this)).fail(function() {
                // Fallback if AJAX fails
                $(this).attr("title", "Leave empty for auto-assignment");
            }.bind(this));
        }
    });
    
    // Clear suggestion when user starts typing
    $("#chapter_number").on("input", function() {
        $(this).removeAttr("title");
    });
});

// Set initial values for edit mode
@if($isEdit)
$(document).ready(function() {
    // Set initial values for edit mode
    @php
    echo "    $('#modal-form [name=title]').val('" . addslashes($material->title) . "');\n";
    echo "    $('#modal-form [name=mapel]').val('" . addslashes($material->mapel) . "');\n";
    echo "    $('#modal-form [name=tutor_id]').val('" . $material->tutor_id . "');\n";
    echo "    $('#modal-form [name=batch_id]').val('" . $material->batch_id . "');\n";
    echo "    $('#modal-form [name=type]').val('" . $material->type . "');\n";
    echo "    $('#modal-form [name=youtube_url]').val('" . addslashes($material->youtube_url) . "');\n";
    echo "    $('#modal-form [name=external_link]').val('" . addslashes($material->external_link) . "');\n";
    echo "    $('#modal-form [name=description]').val('" . addslashes($material->description) . "');\n";
    echo "    $('#modal-form [name=content]').val('" . addslashes($material->content) . "');\n";
    echo "    $('#modal-form [name=duration_seconds]').val('" . $material->duration_seconds . "');\n";
    echo "    $('#modal-form [name=chapter_number]').val('" . $material->chapter_number . "');\n";
    echo "    $('#modal-form [name=chapter_title]').val('" . addslashes($material->chapter_title) . "');\n";
    echo "    $('#modal-form [name=material_order]').val('" . $material->material_order . "');\n";
    echo "    $('#modal-form [name=is_public]').prop('checked', " . ($material->is_public ? 'true' : 'false') . ");\n";
    echo "    $('#modal-form [name=is_featured]').prop('checked', " . ($material->is_featured ? 'true' : 'false') . ");\n";
    echo "    $('#modal-form [name=is_completable]').prop('checked', " . ($material->is_completable ? 'true' : 'false') . ");\n";
    @endphp
    
    // Show/hide type-specific fields
    toggleTypeFields();
});
@endif
</script>';

// Replace the existing script section
$existingScriptStart = strpos($content, '@push(\'scripts\')');
$existingScriptEnd = strpos($content, '@endpush', $existingScriptStart);

if ($existingScriptStart !== false && $existingScriptEnd !== false) {
    // Replace the entire script section
    $oldScript = substr($content, $existingScriptStart, $existingScriptEnd + 8 - $existingScriptStart);
    $content = str_replace($oldScript, '@push(\'scripts\')' . $jsEnhancements . '@endpush', $content);
} else {
    // If no script section exists, add it before the closing </body> tag
    $bodyEnd = strpos($content, '</body>');
    if ($bodyEnd !== false) {
        $content = substr_replace($content, '@push(\'scripts\')' . $jsEnhancements . '@endpush' . "\n", $bodyEnd, 0);
    }
}

// Write the updated form
file_put_contents($formPath, $content);

echo "✅ Form updated successfully with JavaScript enhancements!\n\n";

echo "Enhancements added:\n";
echo "1. ✅ Auto-suggests next chapter number when batch is selected\n";
echo "2. ✅ Shows tooltip with suggestion when chapter field is focused\n";
echo "3. ✅ AJAX call to get next chapter number from server\n";
echo "4. ✅ Fallback behavior if AJAX fails\n";
echo "5. ✅ Maintains existing edit mode functionality\n\n";

echo "How it works:\n";
echo "- When user selects a batch, it automatically gets the next chapter number\n";
echo "- Shows placeholder text like 'Next: 3' to guide the user\n";
echo "- If user leaves chapter number empty, it will auto-assign the next number\n";
echo "- Tooltip shows suggestion when user focuses on the chapter field\n\n";

?>