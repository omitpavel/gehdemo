const timeZoneOffset = 0;

function isBST(date) {
    const year = date.getUTCFullYear();
    const startBST = new Date(Date.UTC(year, 2, 31));
    startBST.setUTCDate(startBST.getUTCDate() - startBST.getUTCDay());
    const endBST = new Date(Date.UTC(year, 9, 31));
    endBST.setUTCDate(endBST.getUTCDate() - endBST.getUTCDay());

    return date >= startBST && date < endBST;
}

function UpdateTimer() {
    const DaysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const Months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    const now = new Date();
    const isSummerTime = isBST(now);
    const offsetHours = isSummerTime ? 1 : 0;

    now.setUTCHours(now.getUTCHours() + offsetHours);

    const DayOfWeek = DaysOfWeek[now.getUTCDay()];
    const DayOfMonth = now.getUTCDate();
    const Month = Months[now.getUTCMonth()];
    const Hours = now.getUTCHours();
    const Minutes = now.getUTCMinutes();

    const Ordinal = GetDayOrdinal(DayOfMonth);

    const FormattedTime = `${DayOfWeek} ${DayOfMonth}${Ordinal} ${Month}, ${PadZero(Hours)}:${PadZero(Minutes)}`;

    $('#autotimer').text(FormattedTime);
}

function GetDayOrdinal(day) {
    if (day >= 11 && day <= 13) {
        return 'th';
    }
    switch (day % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
    }
}

function PadZero(num) {
    return (num < 10 ? '0' : '') + num;
}

$(document).ready(function() {
    UpdateTimer();
    setInterval(UpdateTimer, 1000);
});
