<div id="top" style="max-width: 960px; margin: 40px auto; padding: 30px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); font-family: 'Arial', sans-serif; line-height: 1.6; color: #333;">

    <h1 style="text-align: center; color: #2c3e50; font-size: 2.2em; margin-bottom: 25px; border-bottom: 2px solid #3498db; padding-bottom: 15px;">
        Reconfigure an Existing FlashArray
    </h1>

    <p style="text-align: center; font-size: 1.1em; color: #555; margin-bottom: 30px;">
        This guide provides commands to change settings on an already configured Pure Storage FlashArray. Always exercise caution when making configuration changes.
    </p>

    <div style="background-color: #ffe0b2; padding: 15px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #ff9800;">
        <h3 style="color: #e65100; margin-top: 0; margin-bottom: 10px; font-size: 1.2em;">Important Considerations:</h3>
        <ul style="list-style-type: disc; margin-left: 20px; padding: 0; color: #333;">
            <li style="margin-bottom: 5px;"><strong>Permissions:</strong> Ensure you have the necessary Array Admin privileges before executing any modification commands.</li>
            <li style="margin-bottom: 5px;"><strong>Impact:</strong> Understand the potential impact of network or system changes before proceeding. Changes to network settings can disrupt I/O.</li>
            <li style="margin-bottom: 5px;"><strong>Documentation:</strong> Always consult the official Pure Storage documentation for your specific Purity version for the most accurate and detailed information.</li>
            <li style="margin-bottom: 5px;"><strong>Backup Configuration:</strong> Consider taking a configuration snapshot or documenting current settings before making significant changes.</li>
        </ul>
    </div>

    <h2 style="color: #34495e; font-size: 1.8em; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
        Array Identity & Core Management
    </h2>
    <p style="margin-bottom: 15px;">These commands allow you to modify basic array identification and essential management services.</p>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change Array Name:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Renames the FlashArray. This is an array-wide change.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purearray rename &lt;newname&gt;</code></pre>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change DNS Server IP Address(es):</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Updates the DNS servers used by the array for name resolution.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>puredns setattr --nameservers xxx.xxx.xxx.xxx,xxx.xxx.xxx.xxx</code></pre>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change DNS Domain Suffix:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Configures the domain suffix for the array's DNS lookups.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>puredns setattr --domain domainname.com</code></pre>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change Email Relay Server IP Address or FQDN:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Sets the SMTP server for outgoing email alerts.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purearray setattr --relayhost fake.relay.purestorage.com:26</code></pre>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change Email Domain Name:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Sets the sender domain for email alerts from the array.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purearray setattr --senderdomain &lt;sender.com&gt;</code></pre>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change Email Addresses for Alerts:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Manages the list of email recipients for system alerts.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purealert watcher delete/create &lt;email&gt;</code></pre>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change NTP Server IP Address or FQDN:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Configures the Network Time Protocol servers for accurate time synchronization.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purearray setattr --ntpserver MyNTPServer1.com,MyNTPServer2.com</code></pre>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change HTTP Proxy Server Address or FQDN (if used):</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Sets or removes the proxy server for outbound HTTP/HTTPS communication (e.g., Pure1 connectivity).</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purearray setattr --proxy https://192.1.1.1:80</code></pre>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purearray setattr --proxy "" (to remove)</code></pre>
    </div>

    <h2 style="color: #34495e; font-size: 1.8em; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
        Network Interface Configuration
    </h2>
    <p style="margin-bottom: 15px;">These commands modify the IP settings of network interfaces. Use with caution as this can impact connectivity.</p>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change Virtual Interface (e.g., `vir0`):</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Modifies the IP address, netmask, and gateway for a virtual interface, often used for management or file services.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purenetwork eth setattr --address xxx.xxx.xxx.xxx --netmask xxx.xxx.xxx.xxx --gateway xxx.xxx.xxx.xxx vir0</code></pre>
        <p style="font-style: italic; color: #666; margin-top: 10px; margin-bottom: 5px;">Verify the new settings:</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purenetwork list</code></pre>
        <p style="font-style: italic; color: #666; margin-top: 10px; margin-bottom: 5px;">If the interface is not ENABLED, enable it:</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purenetwork eth enable vir0</code></pre>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change Physical Ethernet (ETH) Interface on Controller (e.g., `CT0.ETH0`):</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Modifies the IP settings for a physical Ethernet port on a specific controller.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purenetwork eth setattr --address xxx.xxx.xxx.xxx --netmask xxx.xxx.xxx.xxx --gateway xxx.xxx.xxx.xxx CT0.ETH0</code></pre>
        <p style="font-style: italic; color: #666; margin-top: 10px; margin-bottom: 5px;">Verify the new settings:</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purenetwork list</code></pre>
        <p style="font-style: italic; color: #666; margin-top: 10px; margin-bottom: 5px;">If the interface is not ENABLED, enable it:</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>purenetwork eth enable CT0.ETH0</code></pre>
    </div>

    <h2 style="color: #34495e; font-size: 1.8em; margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
        System Time & Controller Reboot
    </h2>
    <p style="margin-bottom: 15px;">Managing system time and understanding reboot procedures.</p>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Change Time Zone:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Sets the local time zone for the FlashArray.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>puresetup timezone </code></pre>
        <p style="font-style: italic; color: #e74c3c; margin-top: 10px; font-weight: bold;">Note: This command may trigger a controller reboot. If it doesn't, or if you need to manually reboot, use the commands below.</p>
    </div>

    <div style="background-color: #f8f8f8; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee;">
        <h3 style="color: #3498db; margin-top: 0; margin-bottom: 10px; font-size: 1.3em;">Manual Controller Reboot:</h3>
        <p style="font-style: italic; color: #666; margin-bottom: 10px;">Reboots a specific controller. Always ensure the other controller is healthy and capable of maintaining I/O before rebooting one.</p>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>pureboot reboot --primary</code></pre>
        <pre style="background-color: #e9e9e9; padding: 10px; border-radius: 5px; overflow-x: auto; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.9em; color: #000;"><code>pureboot reboot --secondary</code></pre>
    </div>

    <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px dashed #ddd;">
        <p style="font-size: 1.1em; color: #555;">
            Always verify changes after implementation by checking the GUI or running `purearray list` and `purenetwork list`.
        </p>
        <a href="#top" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;">
            Back to Top
        </a>
    </div>

</div>