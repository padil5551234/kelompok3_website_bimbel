<?php

echo "Adding JavaScript enhancements to form...\n";

$formPath = __DIR__ . '/resources/views/admin/material/form.blade.php';

if (!file_exists($formPath)) {
    echo "❌ Form file not found\n";
    exit(1);
}

$content = file_get_contents($formPath);

// Check if the enhancement is already added
if (strpos($content, 'next-chapter') !== false) {
    echo "✅ JavaScript enhancements already exist in form\n";
    exit(0);
}

// Add JavaScript before the closing </body> tag
$jsCode = '
{{-- Chapter Number Enhancement --}}
<script>
$(document).ready(function() {
    // Auto-suggest next chapter number when batch is selected
    $("#batch_id").on("change", function() {
        const batchId = $(this).val();
        if (batchId) {
            $.get("/admin/material/next-chapter/" + batchId, function(data) {
                if (data.next_chapter) {
                    $("#chapter_number").attr("placeholder", "Next: " + data.next_chapter);
                }
            }).fail(function() {
                $("#chapter_number").attr("placeholder", "1");
            });
        } else {
            $("#chapter_number").attr("placeholder", "1");
        }
    });
    
    // Show suggestion tooltip when chapter field is focused
    $("#chapter_number").on("focus", function() {
        const batchId = $("#batch_id").val();
        const currentValue = $(this).val();
        
        if (!currentValue && batchId) {
            $.get("/admin/material/next-chapter/" + batchId, function(data) {
                if (data.next_chapter && !$("#chapter_number").val()) {
                    $(this).attr("title", "Suggested: " + data.next_chapter);
                }
            }.bind(this)).fail(function() {
                $(this).attr("title", "Leave empty for auto-assignment");
            }.bind(this));
        }
    });
    
    // Clear suggestion when user types
    $("#chapter_number").on("input", function() {
        $(this).removeAttr("title");
    });
});
</script>';

$bodyEnd = strpos($content, '</body>');
if ($bodyEnd !== false) {
    $content = substr_replace($content, $jsCode . "\n", $bodyEnd, 0);
    file_put_contents($formPath, $content);
    echo "✅ JavaScript enhancements added successfully!\n\n";
    
    echo "What was added:\n";
    echo "1. ✅ Auto-suggests next chapter number when batch is selected\n";
    echo "2. ✅ Shows placeholder like 'Next: 3' to guide users\n";
    echo "3. ✅ Tooltip with suggestion when chapter field is focused\n";
    echo "4. ✅ Fallback behavior if AJAX fails\n";
    echo "5. ✅ Clears suggestion when user starts typing\n\n";
    
    echo "How it works:\n";
    echo "- When user selects a batch → gets next chapter number automatically\n";
    echo "- Shows helpful placeholder text to guide the user\n";
    echo "- If user leaves chapter empty → system auto-assigns next number\n";
    echo "- If user enters a number → validates and fixes sequencing\n\n";
} else {
    echo "❌ Could not find </body> tag to insert JavaScript\n";
}

?>