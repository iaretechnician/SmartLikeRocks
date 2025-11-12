<div id="top" style="max-width: 960px; margin: 40px auto; padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); font-family: 'Arial', sans-serif; line-height: 1.6; color: #333;">

    <h1 style="text-align: center; color: #2c3e50; font-size: 2.2em; margin-bottom: 25px; border-bottom: 2px solid #3498db; padding-bottom: 15px;">
        Common FlashArray Errors & Troubleshooting
    </h1>

    <p style="font-size: 1.1em; color: #555; margin-bottom: 30px; text-align: center;">
        This page outlines common errors encountered during FlashArray installation, upgrades, or daily operations, along with their typical troubleshooting steps and cures.
    </p>

    <div style="background-color: #e0f7fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #00bcd4;">
        <h3 style="color: #00838f; margin-top: 0; margin-bottom: 10px; font-size: 1.2em;">General Troubleshooting Philosophy:</h3>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            <li style="margin-bottom: 5px;"><strong>Start Simple:</strong> Many issues can be resolved with basic physical checks or reboots.</li>
            <li style="margin-bottom: 5px;"><strong>Verify First:</strong> Always confirm the error, check logs, and understand the context before making changes.</li>
            <li style="margin-bottom: 5px;"><strong>Document Steps:</strong> Keep track of every command run and its outcome.</li>
            <li style="margin-bottom: 5px;"><strong>Pure Storage Support:</strong> Don't hesitate to engage support for complex or persistent issues.</li>
        </ul>
    </div>

    <h2 style="color: #34495e; font-size: 1.8em; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
        Basic Physical Checks & Component Resets
    </h2>
    <p style="margin-bottom: 15px;">Before diving into complex commands, always verify the physical layer.</p>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Common Fixes for Connectivity/Component Glitches:</h3>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            <li style="margin-bottom: 8px;"><strong>Reseat the card:</strong> For I/O modules, HBAs, or mezzanine cards. Ensure it's fully seated in its slot.</li>
            <li style="margin-bottom: 8px;"><strong>Reseat the controller:</strong> Pull the controller out partially and slide it back in fully.</li>
            <li style="margin-bottom: 8px;"><strong>Reboot the controller:</strong> If a single controller is acting erratically and its peer is healthy.</li>
            <li style="margin-bottom: 8px;"><strong>Check cable connection:</strong> Physically inspect and reseat all relevant network or SAS cables.</li>
            <li style="margin-bottom: 8px;"><strong>Swap cable or SFP:</strong> If you suspect a faulty cable or Small Form-factor Pluggable (SFP) module, swap it with a known good one to see if the issue follows the component.</li>
        </ul>
    </div>

    <h2 style="color: #34495e; font-size: 1.8em; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
        Specific Error Messages & Their Cures
    </h2>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #e74c3c; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Error: `nonetype is not iterable` (During NDU `puresetup replace`)</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">This error often indicates an issue with a virtual interface that needs to be re-enabled or addressed.</p>
        <p style="font-weight: bold; color: #555; margin-bottom: 10px;">Cure:</p>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            <li style="margin-bottom: 8px;">First, attempt to enable the virtual interface:
                <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000; margin-top: 5px;"><code>purenetwork eth enable vir0</code></pre>
            </li>
            <li style="margin-bottom: 8px;">If that fails, investigate the virtual network configuration:
                <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000; margin-top: 5px;"><code>purenursery list config/network/virtual</code></pre>
            </li>
            <li style="margin-bottom: 8px;">If the output lists `virtual_2.1` (or similar unexpected virtual interfaces), you may need to remove it. Consult Pure Support before removing nursery configurations:
                <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000; margin-top: 5px;"><code>purenursery remove config/network/virtual,1</code></pre>
            </li>
        </ul>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #e74c3c; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Issue: DFS Shelf is listed as `SHx` but has the wrong ID or is in an incorrect slot.</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">A DirectFlash Shelf might show up with a generic `SHx` ID or be physically installed in a slot that isn't the primary recommended slot (e.g., Slot 2 instead of Slot 1 for an SAS HBA on some XR4 models).</p>
        <p style="font-weight: bold; color: #555; margin-bottom: 10px;">Cure:</p>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            <li style="margin-bottom: 8px;">The shelf will still typically function normally even if in a non-primary slot, but verify proper cabling.</li>
            <li style="margin-bottom: 8px;">Always double-check shelf cables. Ensure they are correctly seated and follow the cabling guide for your specific FlashArray and DirectFlash Shelf models. Shelf IDs are assigned automatically based on cabling.</li>
        </ul>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #e74c3c; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Error: `stor_ops.command_failure` / `error: bdev.aio.ioctl`</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">These errors are often indicative of underlying drive issues or a controller problem affecting drive access.</p>
        <p style="font-weight: bold; color: #555; margin-bottom: 10px;">Cure:</p>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            <li style="margin-bottom: 8px;">First, attempt a controller reboot. If the problem persists or recurs, contact Pure Storage Support as it may indicate a bad drive or controller component requiring replacement.</li>
        </ul>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #e74c3c; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Error: `directory_service pureds test failure`</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">This specific test failure is often encountered and can typically be ignored if other directory services are functioning correctly and no actual access issues are observed.</p>
        <p style="font-weight: bold; color: #555; margin-bottom: 10px;">Cure:</p>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            <li style="margin-bottom: 8px;">Normal, ignore this specific test failure unless accompanied by other symptoms or active directory problems.</li>
        </ul>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #e74c3c; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Error: `No space left on device`</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">This error indicates that the array's internal system partitions (not user data volumes) are running out of space, typically due to accumulated old files.</p>
        <p style="font-weight: bold; color: #555; margin-bottom: 10px;">Cure:</p>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            <li style="margin-bottom: 8px;">Delete old copies of Purity software packages from `/home/puresupport` or `/var/home/puresupport`.</li>
            <li style="margin-bottom: 8px;">Delete old diagnostic logs or support bundles from `/var/log`.</li>
            <li style="margin-bottom: 8px;">Always confirm with Pure Storage Support before deleting files if you are unsure of their purpose.</li>
        </ul>
    </div>

    <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px dashed #ddd;">
        <p style="font-size: 0.9em; color: #777;">
            This list covers common scenarios. For detailed diagnostics and advanced troubleshooting, always refer to official Pure Storage documentation and engage Technical Support.
        </p>
        <a href="#top" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;">
            Back to Top
        </a>
    </div>

</div>