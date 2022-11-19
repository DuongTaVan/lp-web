<div class="step-wrapper-sp">
    <div class="left position-relative">
        <div class="next-step">
            <div class="circle d-flex justify-content-center align-items-center">
                {{ $step }}
            </div>
        </div>
        <div class="next-step-full"></div>
    </div>
    <div class="header-title f-w6">
        {{ $title }}
    </div>
</div>

<style>
    .step-wrapper-sp {
        display: flex;
        align-items: center;
        height: 66px;
        background: #F6F6F6;
        border: 1px solid rgba(78, 87, 104, 0.2);
        box-sizing: border-box;
        border-radius: 5px;
        padding-left: 13px;
    }

    .step-wrapper-sp .header-title {
        font-weight: 600;
        font-size: 18px;
        color: #2A3242;
        margin-left: 16px;
        flex: 1;
    }

    .step-wrapper-sp .left {
        height: {{ $size }}px;
        width: {{ $size }}px;
    }

    .step-wrapper-sp .next-step {
        --degree: {{ $deg }}deg;
        --color: #64CB90;
    }

    .step-wrapper-sp .next-step {
        position: absolute;
        height: 100%;
        width: 100%;
        border-radius: 50%;
        background: conic-gradient(
                var(--color) var(--degree), transparent calc(var(--degree) + 0.5deg) 100%);
        z-index: 2;
    }

    .step-wrapper-sp .next-step-full {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: conic-gradient(
                #D4D6DA 360deg, transparent calc(360deg + 0.5deg) 100%);
        z-index: 1;
    }

    .step-wrapper-sp .circle {
        height: 84%;
        width: 84%;
        top: 8%;
        right: 8%;
        position: absolute;
        border-radius: 50%;
        background: #F6F6F6;
        color: rgba(78, 87, 104, 0.5);
        font-weight: bold;
        font-size: 12px;
        z-index: 3;
    }
</style>
