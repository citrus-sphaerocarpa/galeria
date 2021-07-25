<template>
    <div>
        {{ convertUTC() }}
    </div>
</template>

<script>
    import { format } from 'date-fns';
    import { utcToZonedTime } from 'date-fns-tz';
    
    export default {
        props: ['date'],
        data: function() {
            return {
                format,
                utcToZonedTime,
            }
        },

        created: function() {

        },

        mounted: function() {
                
        },

        methods: {

            convertUTC() {
                const date = new Date(this.date)
                const userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

                const localeDate = utcToZonedTime(date, userTimeZone);

                return format(localeDate, 'yyyy-MM-dd HH:mm:ss');
            }

        },
    }
</script>