<div id="top" style="max-width: 960px; margin: 40px auto; padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); font-family: 'Arial', sans-serif; line-height: 1.6; color: #333;">

    <h1 style="text-align: center; color: #2c3e50; font-size: 2.2em; margin-bottom: 25px; border-bottom: 2px solid #3498db; padding-bottom: 15px;">
        Evergreen//One (EG/1) Service Mode & Pure Edge Services (PES)
    </h1>

    <p style="font-size: 1.1em; color: #555; margin-bottom: 30px; text-align: center;">
        Understanding Evergreen//One specific configurations is crucial for new FlashArray installations under this service model.
    </p>

    <div style="background-color: #e0f7fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #00bcd4;">
        <h3 style="color: #00838f; margin-top: 0; margin-bottom: 10px; font-size: 1.2em;">Key Directive for EG/1 Installations:</h3>
        <p style="font-weight: bold; color: #e74c3c; margin-bottom: 10px;">
            <span style="font-size: 1.2em; margin-right: 5px;">&#9888;</span> Implementation Engineers:
        </p>
        <p style="color: #333;">
            If a FlashArray is being installed as part of Pure Storage's Evergreen//One (EG//1) Fleet, you <strong style="color: #e74c3c;">MUST ensure that you enable EG//1 Service Mode</strong> prior to sharing your Transfer of Knowledge/GUI Review with the customer!
        </p>
    </div>

    <!-- Section: Evergreen//One Service Mode -->
    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #eee;">
        <h2 style="color: #3498db; margin-top: 0; margin-bottom: 15px; font-size: 1.6em;">Evergreen//One Service Mode</h2>
        <p style="color: #333; margin-bottom: 15px;">
            Evergreen//One Service Mode is a special configuration for FlashArrays introduced with Purity//FA 6.4.10 and later. Its primary purpose is to align the array's displayed capacity metrics with the actual service metrics used by Evergreen//One.
        </p>
        <h3 style="color: #3498db; margin-top: 25px; margin-bottom: 10px; font-size: 1.3em;">Benefits:</h3>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            <li style="margin-bottom: 5px;">Provides real-time service experience.</li>
            <li style="margin-bottom: 5px;">Eliminates confusion regarding capacity metrics.</li>
            <li style="margin-bottom: 5px;">Reduces the number of escalations related to billing/capacity discrepancies.</li>
            <li style="margin-bottom: 5px;">Provides a springboard for future advancements in Evergreen//One services.</li>
        </ul>
        <p style="font-weight: bold; color: #555; margin-top: 20px; margin-bottom: 10px;">Configuration Command:</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow