<div class="flex justify-center items-center min-h-screen" x-data="{ showSplash: true }" x-init="setTimeout(() => showSplash = false, 2500)">
    <!-- Splash Screen -->
    <div x-show="showSplash" class="fixed inset-0 flex justify-center items-center bg-white z-50">
        {{--        <img class="h-full w-full object-cover" src="{{ $this->campaign->splash_image_url }}" alt="Splash Image">--}}
    </div>

    <div  x-show="!showSplash" x-transition class="w-full max-w-lg bg-white p-4 rounded-lg">
        <div class=" flex justify-center ">
            <img class="h-auto w-full lg:w-full" src="/CompanyLogo.png" alt="CompanyLogo.png">
        </div>
        <form wire:submit="create" class="w-full">
            <div  class="flex justify-center ">
                <h2 class="text-xl font-bold leading-tight text-gray-800  text-center">
                    {{$poll->title}}
                </h2>

            </div>
            <div  class="flex justify-center ">
                <p class="text-m  leading-tight text-gray-800 mb-4 text-center">
                    {{--                    {{$this->organization->name??''}}--}}
                </p>
            </div>
            <div class="space-y-6 mt-4 mb-4">
                @foreach ($poll->options as $option)
                    <label class="flex items-center space-x-6">
                        <input type="radio" name="poll_option_id" value="{{ $option->id }}"
                               wire:model="data.poll_option_id"
                               class="form-radio text-blue-600 focus:ring-blue-500 scale-125">
                        <img src="{{ Storage::url($option->image) }}" alt="{{ $option->option }}"
                             class="w-20 h-20 rounded-md object-cover">
                        <span class="text-lg font-semibold">{{ $option->option }}</span>
                    </label>
                @endforeach
            </div>
            @error('data.poll_option_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror


            {{ $this->form }}

            <div class="flex justify-center ">
                <x-filament::button type="submit" class="mt-4  text-white py-2 px-4 rounded mx-auto w-60">
                    Submit
                </x-filament::button>
            </div>
        </form>


        <x-filament-actions::modals />

    </div>
    <x-filament::modal
        id="success-modal"
        icon="heroicon-o-check-circle"
        icon-color="success"
        sticky-header
        width="md"
        class="rounded-md"
        :autofocus="false"
        x-on:close-modal.window="$wire.closeModal()">
        <x-slot name="heading">
            Vote Complete
        </x-slot>
        <x-slot name="description">
            Thank you for completing this form!
        </x-slot>
{{--        <div class="px-4 py-2">--}}
{{--            <table class="table-auto w-full">--}}
{{--                <tbody>--}}
{{--                <tr class="border-b">--}}
{{--                    <td class="px-4 py-2">Employee ID</td>--}}
{{--                    <td class="px-4 py-2">{{ $data['employee_id'] ?? '' }}</td>--}}
{{--                </tr>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
    </x-filament::modal>

    <x-filament::modal
        id="error-modal"
        icon="heroicon-o-check-circle"
        icon-color="danger"
        sticky-header
        width="md"
        class="rounded-md"
        :autofocus="false">
        <x-slot name="heading">
            Error
        </x-slot>
        <x-slot name="description">
            Please check this error message!
        </x-slot>
        <div class="px-4 py-2 ">
            {{$this->error}}
        </div>
    </x-filament::modal>

</div>
