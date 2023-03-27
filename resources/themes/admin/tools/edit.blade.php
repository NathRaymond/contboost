<x-app-layout>
    <x-tools-form :locales="$locales" :tool="$tool" :route="route('admin.tools.edit', $tool)" :title="__('admin.editTool')" :button_text="__('common.update')"
         :categories="$categories" :tags="$tags" />
</x-app-layout>
