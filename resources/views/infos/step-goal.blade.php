<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adım Hedefi Seçimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;900&display=swap" rel="stylesheet"/>
    <style>
        /* CSS stilleriniz istediğiniz gibi korundu */
        body { font-family: "Poppins", sans-serif; background-color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; overflow-x: hidden; }
        .app-container { max-width: 490px; min-height: 844px; background: white; position: relative; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding-bottom: 30px; }
        .back-button { position: absolute; top: 58px; left: 31px; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; cursor: pointer; text-decoration: none; }
        .back-button .icon { width: 12px; height: 12px; border-left: 2px solid #0a0615; border-bottom: 2px solid #0a0615; transform: rotate(45deg); }
        .progress-bar-indicator { width: 59px; height: 8px; background: #dae0e8; border-radius: 4px; margin: 0 auto; margin-top: 66px; }
        .title { color: #0a0615; font-size: 27px; font-weight: 600; text-align: center; margin-top: 80px; padding: 0 30px; }
        .info-box { background-color: #eff9ef; padding: 15px; margin: 30px auto 0; width: calc(100% - 84px); max-width: 318px; position: relative; display: flex; flex-direction: column; align-items: flex-start; text-align: left; }
        .info-box .recommended-tag { background: #6fc66b; color: white; font-size: 10px; font-weight: 500; border-radius: 12px; padding: 4px 10px; position: absolute; top: 8px; right: 8px; z-index: 1; }
        .info-box p { font-size: 10px; font-family: Poppins; font-weight: 500; line-height: 1.4; color: black; margin-bottom: 0; }
        .info-box .emoji { font-size: 21px; position: absolute; left: 15px; top: 25px; }
        .info-box .text-content { padding-left: 45px; }
        .step-goal-input { margin-top: 30px; padding: 0 20px; }
        .step-goal-input .form-control { border: 1px solid #ddd; border-radius: 10px; padding: 15px; text-align: center; font-size: 24px; font-weight: 600; color: #0a0615; box-shadow: none; }
        .step-adjust-buttons { display: flex; justify-content: center; gap: 20px; margin-top: 20px; }
        .step-adjust-buttons button { background-color: #34383e; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 30px; display: flex; justify-content: center; align-items: center; cursor: pointer; transition: background-color 0.3s ease; }
        .continue-button-container { position: absolute; bottom: 90px; left: 50%; transform: translateX(-50%); width: calc(100% - 32px); max-width: 359px; }
        .continue-button { width: 100%; height: 48px; background: linear-gradient(77deg, #262b30 0%, rgba(38, 43, 48, 0.88) 100%); box-shadow: 0px 6px 10px rgba(83, 47, 170, 0.2); border-radius: 25px; color: white; font-size: 20px; font-weight: 900; display: flex; justify-content: center; align-items: center; border: none; cursor: pointer; text-decoration: none; }
        .home-indicator { position: absolute; bottom: 19px; left: 50%; transform: translateX(-50%); width: 134px; height: 5px; background: black; border-radius: 100px; }
    </style>
</head>
<body>
<div class="container-fluid app-container">
    <form method="POST" action="{{ route('infos.step-goal.store') }}" class="w-100 h-100">
        @csrf

        <a href="{{ route('infos.focus') }}" class="back-button">
            <div class="icon"></div>
        </a>


        <h1 class="title">ADIM HEDEFINIZI SEÇIN</h1>

        <div class="info-box">
            <span class="emoji">😎</span>
            <div class="text-content">
                <p>Dünya Sağlık Örgütü uygun bir fiziksel aktivite düzeyi
                olarak günde en az 10.000 adım atılmasını önermektedir.</p>
            </div>

        </div>

        <div class="step-goal-input">
            <input
                type="number"
                name="step_goal"
                class="form-control"
                value="{{ $savedStepGoal ?? 10000 }}"
                min="1000"
                step="500"/>
        </div>

        <div class="step-adjust-buttons">
            <button type="button" id="decrease-steps">-</button>
            <button type="button" id="increase-steps">+</button>
        </div>

        <div class="continue-button-container">
            <button type="submit" class="continue-button">
                Devam et
            </button>
        </div>

    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stepInput = document.querySelector(".step-goal-input .form-control");
        const decreaseBtn = document.getElementById("decrease-steps");
        const increaseBtn = document.getElementById("increase-steps");

        if (stepInput && decreaseBtn && increaseBtn) {
            decreaseBtn.addEventListener("click", function () {
                let currentValue = parseInt(stepInput.value);
                let step = parseInt(stepInput.step);
                let min = parseInt(stepInput.min);
                if (!isNaN(currentValue) && currentValue > min) {
                    stepInput.value = currentValue - step;
                }
            });

            increaseBtn.addEventListener("click", function () {
                let currentValue = parseInt(stepInput.value);
                let step = parseInt(stepInput.step);
                if (!isNaN(currentValue)) {
                    stepInput.value = currentValue + step;
                }
            });
        }
    });
</script>
</body>
</html>
