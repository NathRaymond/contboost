@props([
    'selected_document' => null,
])
<div id="ai-document"></div>
@php
    $content = '';
    foreach ($selected_document->requests as $index => $requests) {
        if ($index > 0) {
            $content .= "\n\n—\n\n";
        }
        $content .= $requests->result;
    }
@endphp
@push('page_scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            AIDocument.setMarkdown(
                "{{ str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', $content), "\0..\37'\\"))) }}"
            )
            AIDocument.moveCursorToStart()
        });
        document.addEventListener("DOMContentLoaded", function(event) {
            var themeMode = document.querySelector('.theme-mode');
            const AIEditor = document.querySelector('.toastui-editor-defaultUI');
            if (themeMode.classList.contains('theme-mode-light')) {
                AIEditor.classList.add('toastui-editor-dark')
                AIEditor.classList.remove('toastui-editor-light')
            } else {
                AIEditor.classList.remove('toastui-editor-dark')
                AIEditor.classList.add('toastui-editor-light')
            }
        });
    </script>
@endpush
