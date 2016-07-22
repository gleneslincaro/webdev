
/*
 * mission javascript
 *
 */
if ($("#time-left").val() != "") {
    if (secs_remaining <= 0 && mins_remaining <= 0 && hours_remaining <= 0 && days_remaining <= 0) {
        $('#remaining-time').text('00秒');
    }
    else {
        createTime();
        $('#remaining-time').text(time);
        var countdownTimer = setInterval('remainingTime()', 1000);
    }
}

function remainingTime() {
    if (secs_remaining == 0) {
        secs_remaining = 59;
        if (mins_remaining == 0) {
            mins_remaining = 59;
            if (hours_remaining == 0) {
                hours_remaining = 23;
                if (days_remaining == 0) {
                    clearInterval(countdownTimer);
                }
                else {
                    days_remaining--;
                }
            }
            else {
                hours_remaining--;
            }
        }
        else {
            mins_remaining--;
        }
    }
    else {
        secs_remaining--;
    }
    createTime();
    $('#remaining-time').text(time);
}

function addZero(num) {
    if (num < 10) {
        return '0'+num;
    }
    else {
        return num;
    }
}

function createTime() {
    time = '';
    if (days_remaining > 0) {
        time = time + addZero(days_remaining)+' 日';
    }
    if (hours_remaining > 0 || (hours_remaining == 0 && days_remaining > 0)) {
        time = time + addZero(hours_remaining)+' 時間';
    }
    if (mins_remaining > 0 || (mins_remaining == 0 && hours_remaining > 0) || (mins_remaining == 0 && hours_remaining == 0 && days_remaining > 0)) {
        time = time + addZero(mins_remaining)+' 分';
    }
    time = time + addZero(secs_remaining)+' 秒';
    if (secs_remaining <= 0 && mins_remaining <= 0 && hours_remaining <= 0 && days_remaining <= 0) {
        time = '00秒';
        clearInterval(countdownTimer);
    }
}

function requestMagnificationBonus() {
    $.post(base_url + 'user/mission/requestMagnificationBonus',{ campaign_progress_id: suncp_id }, function(){
        document.getElementById("request-magnification-bonus").disabled = true;
        alert('倍率ボーナス申請済み');
    });
}

