<div id="top" style="max-width: 960px; margin: 40px auto; padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); font-family: 'Arial', sans-serif; line-height: 1.6; color: #333;">

    <h1 style="text-align: center; color: #2c3e50; font-size: 2.2em; margin-bottom: 25px; border-bottom: 2px solid #3498db; padding-bottom: 15px;">
        Understanding FlashArray Replication Connectivity
    </h1>

    <p style="font-size: 1.1em; color: #555; margin-bottom: 30px; text-align: center;">
        FlashArray replication ensures data protection and disaster recovery by synchronizing data between arrays. This section covers advanced replication configuration options.
    </p>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #eee;">
        <h2 style="color: #3498db; margin-top: 0; margin-bottom: 15px; font-size: 1.6em;">Replibond: Aggregating Replication Bandwidth</h2>
        <p style="color: #333; margin-bottom: 15px;">
            [cite_start]Replibond is a feature that allows you to 'bond' multiple Ethernet ports to a single IP address, effectively aggregating their bandwidth for replication traffic[cite: 5747]. This enables the array to utilize all designated replication ports as if they were a single, higher-bandwidth connection. It is simple to configure.
        </p>

        <h3 style="color: #3498db; margin-top: 25px; margin-bottom: 10px; font-size: 1.3em;">Replibond Configuration Commands:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">These commands configure a Replibond interface. Replace `0.0.0.0` with appropriate IP details.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000; margin-bottom: 10px;"><code>purenetwork eth setattr --address 0.0.0.0 --netmask 0.0.0.0 --gateway 0.0.0.0 replbond</code></pre>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Then, add the desired physical Ethernet interfaces to the replibond. Remember to verify the actual interface names on your array (e.g., `eth2`, `eth3` may vary by model or card slot).</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000; margin-bottom: 10px;"><code>purenetwork eth setattr --addsubinterfacelist eth2 replbond</code></pre>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000; margin-bottom: 10px;"><code>purenetwork eth setattr --addsubinterfacelist eth3 replbond</code></pre>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Finally, enable the replibond interface:</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purenetwork enable replbond</code></pre>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h2 style="color: #3498db; margin-top: 0; margin-bottom: 15px; font-size: 1.6em;">Using Management Ports for Replication</h2>
        <p style="color: #333; margin-bottom: 15px;">
            [cite_start]In certain scenarios, such as to accommodate a customer's network setup that primarily utilizes RJ45 connections, you may need to use the `eth1` (management) ports on CT0 and CT1 for replication[cite: 5749].
        </p>
        <p style="font-weight: bold; color: #e74c3c; margin-bottom: 15px;">
            <span style="font-size: 1.2em; margin-right: 5px;">&#9888;</span> Important Downside:
        </p>
        <p style="color: #333; margin-bottom: 15px;">
            [cite_start]If using `eth1` ports for replication, the replication speed will be limited to 1 Gigabit per second (1GB speeds)[cite: 5749]. This is significantly slower than dedicated 10/25/100GbE replication ports.
        </p>

        <h3 style="color: #3498db; margin-top: 25px; margin-bottom: 10px; font-size: 1.3em;">Basic Configuration Steps:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">You would enable the `eth1` port as you normally would for any network interface:</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000; margin-bottom: 10px;"><code>purenetwork eth setattr --address 1.2.3.5 --netmask 255.255.255.254 --gateway 1.2.3.4 ct0.eth1</code></pre>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000; margin-bottom: 15px;"><code>purenetwork eth enable ct0.eth1</code></pre>

        <h3 style="color: #e74c3c; margin-top: 25px; margin-bottom: 10px; font-size: 1.3em;">Critical Support Involvement Required:</h3>
        <p style="color: #333; margin-bottom: 15px;">
            [cite_start]While the basic IP configuration is straightforward, changing the *service role* of these management ports (`eth1`) to dedicated replication requires specific internal configurations within the array's Purity Operating Environment. Pure Storage Support needs to be aware of and configure this service change[cite: 5752].
        </p>
        <p style="font-weight: bold; color: #555; margin-bottom: 10px;">To finalize this configuration, you must:</p>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            [cite_start]<li style="margin-bottom: 8px;">Create a Support Case on Slack via `#ask_supportmanagement`[cite: 5752].</li>
            <li style="margin-bottom: 8px;">Inform them that the `eth1` ports are being used for replication.</li>
            [cite_start]<li style="margin-bottom: 8px;">A TSE3 agent will be required to configure the necessary internal settings (e.g., tunables or service assignments) for these ports[cite: 5752]. <strong style="color: #e74c3c;">Do NOT attempt to manually configure the service type of these ports without direct guidance from a TSE3 agent or higher-level support.</strong></li>
        </ul>
    </div>

    <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px dashed #ddd;">
        <p style="font-size: 0.9em; color: #777;">
            Proper replication setup is vital for data integrity and disaster recovery strategies.
        </p>
        <a href="#top" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;">
            Back to Top
        </a>
    </div>

</div>