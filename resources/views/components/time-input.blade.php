@props(['selectedHour', 'selectedMinute', 'selectedPeriod'])
<div x-data="{ open: false, selectedHour: '5', selectedMinute: '15', selectedPeriod: '{{$selectedPeriod ?? 'PM'}}' } ">
    <!-- Trigger button -->
    <div class="flex justify-items-start items-center space-x-2 bg-white p-4 rounded shadow">
        <!-- Hours selection -->
        <span class="mx-2 mr-2">Hour</span>
        <select name="hours" x-model="selectedHour" class="border p-2">
            <!-- Generating options for hours -->
            <template x-for="hour in Array.from({ length: 12 }, (_, i) => i + 1)" :key="hour">
                <option :selected="hour === {{$selectedHour ?? '00'}}" x-text="hour < 10 ? '0' + hour : hour" :value="hour < 10 ? '0' + hour : hour"></option>
            </template>
        </select>
        <span class="mx-2 mr-2 ml-2">Minutes</span>    
        <!-- Minutes selection -->
        <select name="minutes" x-model="selectedMinute" class="border p-2">
            <!-- Generating options for minutes -->
            <template x-for="minute in ['00', '15', '25', '30', '45']">
                <option :selected="minute === '{{$selectedMinute ?? '00'}}'" x-text="minute" :value="minute"></option>
            </template>
        </select>
        <span class="mx-2 mr-2 ml-2"></span>   
        <!-- AM/PM selection -->
        <select name="period" x-model="selectedPeriod" class="border p-2">
            <option value="AM">AM</option>
            <option value="PM">PM</option>
        </select>
    </div>
</div>