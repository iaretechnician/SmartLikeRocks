<div id="top" style="max-width: 960px; margin: 40px auto; padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); font-family: 'Arial', sans-serif; line-height: 1.6; color: #333;">

    <h1 style="text-align: center; color: #2c3e50; font-size: 2.2em; margin-bottom: 25px; border-bottom: 2px solid #3498db; padding-bottom: 15px;">
        VPN Access & Security Tools
    </h1>

    <p style="font-size: 1.1em; color: #555; margin-bottom: 30px; text-align: center;">
        Secure network access is paramount when interacting with FlashArrays and internal Pure Storage resources. This page details how to connect via VPN and utilize essential security software.
    </p>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #eee;">
        <h2 style="color: #3498db; margin-top: 0; margin-bottom: 15px; font-size: 1.6em;">Global Protect VPN</h2>
        <p style="color: #333; margin-bottom: 15px;">
            [cite_start]You need to use the VPN whenever you log in to an array using the Challenge/Response feature on your Pure Dashboard[cite: 1]. Global Protect provides a secure tunnel for your network traffic.
        </p>

        <h3 style="color: #3498db; margin-top: 25px; margin-bottom: 10px; font-size: 1.3em;">Obtaining & Connecting to Global Protect:</h3>
        <ul style="list-style-type: decimal; margin-left: 25px; padding: 0; color: #333;">
            <li style="margin-bottom: 10px;">
                [cite_start]First, you must have downloaded Global Protect[cite: 1].
            </li>
            <li style="margin-bottom: 10px;">
                [cite_start]Go to the Global Protect login portal: <a href="https://webvpn.purestorage.com/global-protect/login.esp" target="_blank" style="color: #3498db; text-decoration: none;">https://webvpn.purestorage.com/global-protect/login.esp</a>[cite: 1].
            </li>
            <li style="margin-bottom: 10px;">
                [cite_start]You will then need to log in using your PURE credentials[cite: 1].
                <ul style="list-style-type: circle; margin-left: 20px; padding: 0; margin-top: 5px;">
                    [cite_start]<li style="margin-bottom: 5px;">Username: Your Pure Storage email without "@purestorage.com"[cite: 1].</li>
                    [cite_start]<li>Password: Your Pure Storage login password[cite: 1].</li>
                </ul>
            </li>
            <li style="margin-bottom: 10px;">
                [cite_start]Once you are logged in, it will prompt you to download a version of Global Protect for your laptop[cite: 1]. Follow the on-screen instructions for installation.
            </li>
            <li style="margin-bottom: 10px;">
                [cite_start]After you have logged in and downloaded Global Protect, in the bottom right corner of your screen (system tray), make sure to connect your VPN to "Auto-Discovery"[cite: 1]. This will establish your connection to the VPN.
            </li>
            <li style="margin-bottom: 10px;">
                [cite_start]Once you are connected to the VPN, you can now open Challenge/Response without an issue[cite: 1].
            </li>
        </ul>
    </div>

    <div style="background-color: #e0f7fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #00bcd4;">
        <h2 style="color: #00838f; margin-top: 0; margin-bottom: 15px; font-size: 1.6em;">zProtect Software</h2>
        <p style="color: #333; margin-bottom: 15px;">
            zProtect is an advanced security application designed to enhance the integrity and security of your workstation and sensitive operations. It provides an additional layer of protection, particularly vital when dealing with customer environments and proprietary data.
        </p>

        <h3 style="color: #00838f; margin-top: 25px; margin-bottom: 10px; font-size: 1.3em;">Obtaining & Using zProtect:</h3>
        <ul style="list-style-type: decimal; margin-left: 25px; padding: 0; color: #333;">
            <li style="margin-bottom: 10px;">
                <strong>Obtaining zProtect:</strong> Typically, zProtect will be deployed via your corporate endpoint management system. If it is not automatically installed on your provisioned laptop, please contact TSP IT Support for deployment. Do not attempt to download it from external sources.
            </li>
            <li style="margin-bottom: 10px;">
                <strong>Installation:</strong> Follow the instructions provided by TSP IT. This usually involves running an installer package and may require a system reboot.
            </li>
            <li style="margin-bottom: 10px;">
                <strong>Activation:</strong> Once installed, zProtect often requires activation or linking to your corporate identity. Ensure it's active and running in your system tray or background processes.
            </li>
            <li style="margin-bottom: 10px;">
                <strong>Usage:</strong> zProtect operates largely in the background, enforcing security policies. Be aware of any notifications or alerts from the software, as they may indicate a security event or compliance issue that requires your attention. It works in conjunction with your VPN connection to provide end-to-end secure access.
            </li>
        </ul>
        <div style="background-color: #fffde7; padding: 15px; border-radius: 8px; border: 1px dashed #ffd700; margin-top: 15px;">
            <p style="font-weight: bold; color: #b78a00; margin-bottom: 10px;">
                <span style="font-size: 1.2em; margin-right: 5px;">&#9888;</span> Security Best Practice:
            </p>
            <p style="color: #333;">
                Ensure both your VPN and zProtect are active and functioning correctly before initiating any remote connections to sensitive Pure Storage or customer systems. This compliance is essential for maintaining data security and operational integrity.
            </p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px dashed #ddd;">
        <p style="font-size: 0.9em; color: #777;">
            Maintaining a secure connection is a fundamental responsibility for all field engineers.
        </p>
        <a href="#top" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;">
            Back to Top
        </a>
    </div>

</div>