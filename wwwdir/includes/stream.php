<?php
/*Rev:26.09.18r0*/

class ipTV_stream
{
    public static $ipTV_db;
    static function ($A733a5416ffab6ff47547550f3f9f641)
    {
        if (empty($A733a5416ffab6ff47547550f3f9f641)) {
            return;
        }
        foreach ($A733a5416ffab6ff47547550f3f9f641 as $F3803fa85b38b65447e6d438f8e9176a) {
            if (file_exists(STREAMS_PATH . md5($F3803fa85b38b65447e6d438f8e9176a))) {
                unlink(STREAMS_PATH . md5($F3803fa85b38b65447e6d438f8e9176a));
            }
        }
    }
    static function EeeD2f36fa093b45bC2D622ed0231684($E62a309a7fc72c8c292c032fe0fd23ab)
    {
        self::$ipTV_db->query('
                SELECT * FROM `streams` t1 
                LEFT JOIN `transcoding_profiles` t3 ON t1.transcode_profile_id = t3.profile_id
                WHERE t1.`id` = \'%d\'', $E62a309a7fc72c8c292c032fe0fd23ab);
        $a5fd23cf4a741b0e9eb35bb60849c401 = self::$ipTV_db->get_row();
        $a5fd23cf4a741b0e9eb35bb60849c401['cchannel_rsources'] = json_decode($a5fd23cf4a741b0e9eb35bb60849c401['cchannel_rsources'], true);
        $a5fd23cf4a741b0e9eb35bb60849c401['stream_source'] = json_decode($a5fd23cf4a741b0e9eb35bb60849c401['stream_source'], true);
        $a5fd23cf4a741b0e9eb35bb60849c401['pids_create_channel'] = json_decode($a5fd23cf4a741b0e9eb35bb60849c401['pids_create_channel'], true);
        $a5fd23cf4a741b0e9eb35bb60849c401['transcode_attributes'] = json_decode($a5fd23cf4a741b0e9eb35bb60849c401['profile_options'], true);
        if (!array_key_exists('-acodec', $a5fd23cf4a741b0e9eb35bb60849c401['transcode_attributes'])) {
            $a5fd23cf4a741b0e9eb35bb60849c401['transcode_attributes']['-acodec'] = 'copy';
        }
        if (!array_key_exists('-vcodec', $a5fd23cf4a741b0e9eb35bb60849c401['transcode_attributes'])) {
            $a5fd23cf4a741b0e9eb35bb60849c401['transcode_attributes']['-vcodec'] = 'copy';
        }
        $bf1324315496910e8d570f42b29cf7bb = FFMPEG_PATH . ' -fflags +genpts -async 1 -y -nostdin -hide_banner -loglevel quiet -i "{INPUT}" ';
        $bf1324315496910e8d570f42b29cf7bb .= implode(' ', self::F6664C80BDe3e9BbE2C12ceB906D5A11($a5fd23cf4a741b0e9eb35bb60849c401['transcode_attributes'])) . ' ';
        $bf1324315496910e8d570f42b29cf7bb .= '-strict -2 -mpegts_flags +initial_discontinuity -f mpegts "' . CREATED_CHANNELS . $E62a309a7fc72c8c292c032fe0fd23ab . '_{INPUT_MD5}.ts" >/dev/null 2>/dev/null & jobs -p';
        $Ff86147ddc7b314b8090bc97616612a7 = array_diff($a5fd23cf4a741b0e9eb35bb60849c401['stream_source'], $a5fd23cf4a741b0e9eb35bb60849c401['cchannel_rsources']);
        $F7385aab8f8489bee4d3920b1e33eac7 = '';
        foreach ($a5fd23cf4a741b0e9eb35bb60849c401['stream_source'] as $b593cd195ca5474bf633cc7331d67088) {
            $F7385aab8f8489bee4d3920b1e33eac7 .= 'file \'' . CREATED_CHANNELS . $E62a309a7fc72c8c292c032fe0fd23ab . '_' . md5($b593cd195ca5474bf633cc7331d67088) . '.ts\'
';
            //Dacc3a7743606f9081e171abfd8afd70:
        }
        $F7385aab8f8489bee4d3920b1e33eac7 = base64_encode($F7385aab8f8489bee4d3920b1e33eac7);
        if ((!empty($Ff86147ddc7b314b8090bc97616612a7) || $a5fd23cf4a741b0e9eb35bb60849c401['stream_source'] !== $a5fd23cf4a741b0e9eb35bb60849c401['cchannel_rsources'])) {
            //B2698bb5e4373b49b23f6243176db365:
            foreach ($Ff86147ddc7b314b8090bc97616612a7 as $b593cd195ca5474bf633cc7331d67088) {
                $a5fd23cf4a741b0e9eb35bb60849c401['pids_create_channel'][] = ipTV_servers::RunCommandServer($a5fd23cf4a741b0e9eb35bb60849c401['created_channel_location'], str_ireplace(array('{INPUT}', '{INPUT_MD5}'), array($b593cd195ca5474bf633cc7331d67088, md5($b593cd195ca5474bf633cc7331d67088)), $bf1324315496910e8d570f42b29cf7bb), 'raw')[$a5fd23cf4a741b0e9eb35bb60849c401['created_channel_location']];
                //D55ed4325d42ba3f283b52d86a708783:
            }
            self::$ipTV_db->query('UPDATE `streams` SET pids_create_channel = \'%s\',`cchannel_rsources` = \'%s\' WHERE `id` = \'%d\'', json_encode($a5fd23cf4a741b0e9eb35bb60849c401['pids_create_channel']), json_encode($a5fd23cf4a741b0e9eb35bb60849c401['stream_source']), $E62a309a7fc72c8c292c032fe0fd23ab);
            ipTV_servers::RunCommandServer($a5fd23cf4a741b0e9eb35bb60849c401['created_channel_location'], "echo {$F7385aab8f8489bee4d3920b1e33eac7} | base64 --decode > \"" . CREATED_CHANNELS . $E62a309a7fc72c8c292c032fe0fd23ab . '_.list"', 'raw');
            return 1;
        }
        else if (!empty($a5fd23cf4a741b0e9eb35bb60849c401['pids_create_channel'])) {
            foreach ($a5fd23cf4a741b0e9eb35bb60849c401['pids_create_channel'] as $key => $pid) {
                if (!ipTV_servers::eD79a31441202a0d242A25777F316FaC($a5fd23cf4a741b0e9eb35bb60849c401['created_channel_location'], $pid, FFMPEG_PATH)) {
                    unset($a5fd23cf4a741b0e9eb35bb60849c401['pids_create_channel'][$key]);
                }
            }
            self::$ipTV_db->query('UPDATE `streams` SET pids_create_channel = \'%s\' WHERE `id` = \'%d\'', json_encode($a5fd23cf4a741b0e9eb35bb60849c401['pids_create_channel']), $E62a309a7fc72c8c292c032fe0fd23ab);
            return empty($a5fd23cf4a741b0e9eb35bb60849c401['pids_create_channel']) ? 2 : 1;
        } 
                
        //goto d1cbb96c05439cbb179d4ff78e029ddb;    
        return 2;    
    }
    static function E0A1164567005185e0818F081674E240($C0379dd6700deb6b1021ed6026f648b9, $Aa894918d6f628c53ace2682189e44d5, $f84c1c6145bb73410b3ea7c0f8b4a9f3 = array(), $A7da0ef4553f5ea253d3907a7c9ef7f0 = '')
    {
        $C359d5e5ab36c7a88fca0754166e7996 = abs(intval(ipTV_lib::$settings['stream_max_analyze']));
        $E1be7e0ba659254273dc1475ae9679e0 = abs(intval(ipTV_lib::$settings['probesize']));
        $E2862eaf3f4716fdadef0a008a343507 = intval($C359d5e5ab36c7a88fca0754166e7996 / 1000000) + 5;
        $command = "{$A7da0ef4553f5ea253d3907a7c9ef7f0}/usr/bin/timeout {$E2862eaf3f4716fdadef0a008a343507}s " . FFPROBE_PATH . " -probesize {$E1be7e0ba659254273dc1475ae9679e0} -analyzeduration {$C359d5e5ab36c7a88fca0754166e7996} " . implode(' ', $f84c1c6145bb73410b3ea7c0f8b4a9f3) . " -i \"{$C0379dd6700deb6b1021ed6026f648b9}\" -v quiet -print_format json -show_streams -show_format";
        $result = ipTV_servers::RunCommandServer($Aa894918d6f628c53ace2682189e44d5, $command, 'raw', $E2862eaf3f4716fdadef0a008a343507 * 2, $E2862eaf3f4716fdadef0a008a343507 * 2);
        return self::cCBD051C8a19a02Dc5B6dB256Ae31c07(json_decode($result[$Aa894918d6f628c53ace2682189e44d5], true));
    }
    public static function CcBd051c8a19a02dc5B6dB256AE31c07($d8c887d4a07ddc3992dca7f1d440e7de)
    {
        if (!empty($d8c887d4a07ddc3992dca7f1d440e7de)) {
            if (!empty($d8c887d4a07ddc3992dca7f1d440e7de['codecs'])) {
                return $d8c887d4a07ddc3992dca7f1d440e7de;
            }
            $output = array();
            $output['codecs']['video'] = '';
            $output['codecs']['audio'] = '';
            $output['container'] = $d8c887d4a07ddc3992dca7f1d440e7de['format']['format_name'];
            $output['filename'] = $d8c887d4a07ddc3992dca7f1d440e7de['format']['filename'];
            $output['bitrate'] = !empty($d8c887d4a07ddc3992dca7f1d440e7de['format']['bit_rate']) ? $d8c887d4a07ddc3992dca7f1d440e7de['format']['bit_rate'] : null;
            $output['of_duration'] = !empty($d8c887d4a07ddc3992dca7f1d440e7de['format']['duration']) ? $d8c887d4a07ddc3992dca7f1d440e7de['format']['duration'] : 'N/A';
            $output['duration'] = !empty($d8c887d4a07ddc3992dca7f1d440e7de['format']['duration']) ? gmdate('H:i:s', intval($d8c887d4a07ddc3992dca7f1d440e7de['format']['duration'])) : 'N/A';
            foreach ($d8c887d4a07ddc3992dca7f1d440e7de['streams'] as $E91d1cd26e7223a0f44a617b8ab51d10) {
                if (!isset($E91d1cd26e7223a0f44a617b8ab51d10['codec_type'])) {
                    continue;
                }
                if ($E91d1cd26e7223a0f44a617b8ab51d10['codec_type'] != 'audio' && $E91d1cd26e7223a0f44a617b8ab51d10['codec_type'] != 'video') {
                    continue;
                }
                $output['codecs'][$E91d1cd26e7223a0f44a617b8ab51d10['codec_type']] = $E91d1cd26e7223a0f44a617b8ab51d10;
                //B118807d702f1626af252cf6e1925be3:
            }
            return $output;
        }
        return false;
    }
    static function C27C26b9eD331706a4c3f0292142fB52($stream_id, $a10d30316266ccc4dd75c9b1ce4dd026 = false)
    {
        if (file_exists("/home/xtreamcodes/iptv_xtream_codes/streams/{$stream_id}.monitor")) {
            $e9d30118d498945b35ee33aa90ed9822 = intval(file_get_contents("/home/xtreamcodes/iptv_xtream_codes/streams/{$stream_id}.monitor"));
            if (self::F198E55FC8231996C50ee056Ac4226E0($e9d30118d498945b35ee33aa90ed9822, "XtreamCodes[{$stream_id}]")) {
                posix_kill($e9d30118d498945b35ee33aa90ed9822, 9);
            }
        }
        if (file_exists(STREAMS_PATH . $stream_id . '_.pid')) {
            $pid = intval(file_get_contents(STREAMS_PATH . $stream_id . '_.pid'));
            if (self::F198E55fC8231996C50eE056aC4226e0($pid, "{$stream_id}_.m3u8")) {
                posix_kill($pid, 9);
            }
        }
        shell_exec('rm -f ' . STREAMS_PATH . $stream_id . '_*');
        if ($a10d30316266ccc4dd75c9b1ce4dd026) {
            shell_exec('rm -f ' . DELAY_STREAM . $stream_id . '_*');
            self::$ipTV_db->query('UPDATE `streams_sys` SET `bitrate` = NULL,`current_source` = NULL,`to_analyze` = 0,`pid` = NULL,`stream_started` = NULL,`stream_info` = NULL,`stream_status` = 0,`monitor_pid` = NULL WHERE `stream_id` = \'%d\' AND `server_id` = \'%d\'', $stream_id, SERVER_ID);
        }
    }
    static function F198e55Fc8231996C50eE056ac4226e0($pid, $Afd5f79d62d4622597818545a5cf00d1)
    {
        if (file_exists('/proc/' . $pid)) {
            $ea5780c60b0a2afa62b1d8395f019e9a = trim(file_get_contents("/proc/{$pid}/cmdline"));
            if (stristr($ea5780c60b0a2afa62b1d8395f019e9a, $Afd5f79d62d4622597818545a5cf00d1)) {
                return true;
            }
        }
        return false;
    }
    static function E79092731573697C16A932C339d0A101($stream_id, $c6a482793047d2f533b0b69299b7d24d = 0)
    {
        $d0ecfdcd1b9396ba72538b60109bf719 = STREAMS_PATH . $stream_id . '.lock';
        $fp = fopen($d0ecfdcd1b9396ba72538b60109bf719, 'a+');
        if (flock($fp, LOCK_EX | LOCK_NB)) {
            $c6a482793047d2f533b0b69299b7d24d = intval($c6a482793047d2f533b0b69299b7d24d);
            shell_exec(PHP_BIN . ' ' . TOOLS_PATH . "stream_monitor.php {$stream_id} {$c6a482793047d2f533b0b69299b7d24d} >/dev/null 2>/dev/null &");
            usleep(300);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
    static function b533E0f5f988919d1c3b076a87f9b0E3($stream_id)
    {
        if (file_exists(MOVIES_PATH . $stream_id . '_.pid')) {
            $pid = (int) file_get_contents(MOVIES_PATH . $stream_id . '_.pid');
            posix_kill($pid, 9);
        }
        shell_exec('rm -f ' . MOVIES_PATH . $stream_id . '.*');
        self::$ipTV_db->query('UPDATE `streams_sys` SET `bitrate` = NULL,`current_source` = NULL,`to_analyze` = 0,`pid` = NULL,`stream_started` = NULL,`stream_info` = NULL,`stream_status` = 0 WHERE `stream_id` = \'%d\' AND `server_id` = \'%d\'', $stream_id, SERVER_ID);
    }
    static function f8aB00514d4DB9462A088927b8D3a8E6($stream_id)
    {
        $stream = array();
        self::$ipTV_db->query('SELECT * FROM `streams` t1 
                               INNER JOIN `streams_types` t2 ON t2.type_id = t1.type AND t2.live = 0
                               LEFT JOIN `transcoding_profiles` t4 ON t1.transcode_profile_id = t4.profile_id 
                               WHERE t1.direct_source = 0 AND t1.id = \'%d\'', $stream_id);
        if (self::$ipTV_db->num_rows() <= 0) {
            return false;
        }
        $stream['stream_info'] = self::$ipTV_db->get_row();
        $ecb89a457f7f7216f5564141edfd6269 = json_decode($stream['stream_info']['target_container'], true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $stream['stream_info']['target_container'] = $ecb89a457f7f7216f5564141edfd6269;
        } else {
            $stream['stream_info']['target_container'] = array($stream['stream_info']['target_container']);
        }
        self::$ipTV_db->query('SELECT * FROM `streams_sys` WHERE stream_id  = \'%d\' AND `server_id` = \'%d\'', $stream_id, SERVER_ID);
        if (self::$ipTV_db->num_rows() <= 0) {
            return false;
        }
        $stream['server_info'] = self::$ipTV_db->get_row();
        self::$ipTV_db->query('SELECT t1.*, t2.* FROM `streams_options` t1, `streams_arguments` t2 WHERE t1.stream_id = \'%d\' AND t1.argument_id = t2.id', $stream_id);
        $stream['stream_arguments'] = self::$ipTV_db->get_rows();
        $B16ceb354351bfb3944291018578c764 = urldecode(json_decode($stream['stream_info']['stream_source'], true)[0]);
        if (substr($B16ceb354351bfb3944291018578c764, 0, 2) == 's:') {
            $a3cc823f429df879ce4a238c730d5eb1 = explode(':', $B16ceb354351bfb3944291018578c764, 3);
            $dc4f2a655eb3f009a9e741402d02f5fb = $a3cc823f429df879ce4a238c730d5eb1[1];
            if ($dc4f2a655eb3f009a9e741402d02f5fb != SERVER_ID) {
                $ed147a39fb35be93248b6f1c206a8023 = ipTV_lib::$StreamingServers[$dc4f2a655eb3f009a9e741402d02f5fb]['api_url'] . '&action=getFile&filename=' . urlencode($a3cc823f429df879ce4a238c730d5eb1[2]);
            } else {
                $ed147a39fb35be93248b6f1c206a8023 = $a3cc823f429df879ce4a238c730d5eb1[2];
            }
            $server_protocol = null;
        } else {
            $server_protocol = substr($B16ceb354351bfb3944291018578c764, 0, strpos($B16ceb354351bfb3944291018578c764, '://'));
            $ed147a39fb35be93248b6f1c206a8023 = str_replace(' ', '%20', $B16ceb354351bfb3944291018578c764);
            $be9f906faa527985765b1d8c897fb13a = implode(' ', self::eA860C1D3851c46D06e64911E3602768($stream['stream_arguments'], $server_protocol, 'fetch'));
        }
        if (!(isset($dc4f2a655eb3f009a9e741402d02f5fb) && $dc4f2a655eb3f009a9e741402d02f5fb == SERVER_ID && $stream['stream_info']['movie_symlink'] == 1)) {
            $fd91db723d1a9a2b33d242b8850c593f = json_decode($stream['stream_info']['movie_subtitles'], true);
            $cded98e960569a6cd37bbbc155e6a799 = '';
            $index = 0;
            //A939828d8872169b1d363ce60f3db680:
            while ($index < count($fd91db723d1a9a2b33d242b8850c593f['files'])) {
                $f26614792b40297912d260cb0d2fa273 = urldecode($fd91db723d1a9a2b33d242b8850c593f['files'][$index]);
                $d8143e98f4313d9c05f0b2697179789c = $fd91db723d1a9a2b33d242b8850c593f['charset'][$index];
                if ($fd91db723d1a9a2b33d242b8850c593f['location'] == SERVER_ID) {
                    $cded98e960569a6cd37bbbc155e6a799 .= "-sub_charenc \"{$d8143e98f4313d9c05f0b2697179789c}\" -i \"{$f26614792b40297912d260cb0d2fa273}\" ";
                } else {
                    $cded98e960569a6cd37bbbc155e6a799 .= "-sub_charenc \"{$d8143e98f4313d9c05f0b2697179789c}\" -i \"" . ipTV_lib::$StreamingServers[$fd91db723d1a9a2b33d242b8850c593f['location']]['api_url'] . '&action=getFile&filename=' . urlencode($f26614792b40297912d260cb0d2fa273) . '" ';
                }
                $index++;
            }
            //E404feeb4139fcd9698f5b6a92c598c8:
            $f2130ba0f82d2308b743977b2ba5eaa9 = '';
            $index = 0;
            //E6e19d8ac7fbc7bd7196ad89afc70796:
            while ($index < count($fd91db723d1a9a2b33d242b8850c593f['files'])) {
                $f2130ba0f82d2308b743977b2ba5eaa9 .= '-map ' . ($index + 1) . " -metadata:s:s:{$index} title={$fd91db723d1a9a2b33d242b8850c593f['names'][$index]} -metadata:s:s:{$index} language={$fd91db723d1a9a2b33d242b8850c593f['names'][$index]} ";
                $index++;
            }
            //ad3c3b402990229299a009de2ca8b278:
            $af428179032a83d9ec1df565934b1c89 = FFMPEG_PATH . " -y -nostdin -hide_banner -loglevel warning -err_detect ignore_err {FETCH_OPTIONS} -fflags +genpts -async 1 {READ_NATIVE} -i \"{STREAM_SOURCE}\" {$cded98e960569a6cd37bbbc155e6a799}";
            $feb3f2070e6ccf961f6265281e875b1a = '';
            if ($stream['stream_info']['read_native'] == 1) {
                $feb3f2070e6ccf961f6265281e875b1a = '-re';
            }
            if ($stream['stream_info']['enable_transcode'] == 1) {
                if ($stream['stream_info']['transcode_profile_id'] == -1) {
                    $stream['stream_info']['transcode_attributes'] = array_merge(self::ea860c1d3851c46d06E64911e3602768($stream['stream_arguments'], $server_protocol, 'transcode'), json_decode($stream['stream_info']['transcode_attributes'], true));
                } else {
                    $stream['stream_info']['transcode_attributes'] = json_decode($stream['stream_info']['profile_options'], true);
                }
            } else {
                $stream['stream_info']['transcode_attributes'] = array();
            }
            $fd85ae68a4de5cc6cec54942d82e8f80 = '-map 0 -copy_unknown ';
            if (empty($stream['stream_info']['custom_map'])) {
                $fd85ae68a4de5cc6cec54942d82e8f80 = $stream['stream_info']['custom_map'] . ' -copy_unknown ';
            }
            else if ($stream['stream_info']['remove_subtitles'] == 1) {
                $fd85ae68a4de5cc6cec54942d82e8f80 = '-map 0:a -map 0:v';
            }
            //ab37a681ced15fd3155a018a6c2e6d1c:
            
            //goto C001984484eb7a1780f704ac0e17f07b;
            if (!array_key_exists('-acodec', $stream['stream_info']['transcode_attributes'])) {
                $stream['stream_info']['transcode_attributes']['-acodec'] = 'copy';
            }
            if (!array_key_exists('-vcodec', $stream['stream_info']['transcode_attributes'])) {
                $stream['stream_info']['transcode_attributes']['-vcodec'] = 'copy';
            }
            $A7c6258649492b26d77c75c60c793409 = array();
            foreach ($stream['stream_info']['target_container'] as $container_priority) {
                $A7c6258649492b26d77c75c60c793409[$container_priority] = "-movflags +faststart -dn {$fd85ae68a4de5cc6cec54942d82e8f80} -ignore_unknown {$f2130ba0f82d2308b743977b2ba5eaa9} " . MOVIES_PATH . $stream_id . '.' . $container_priority . ' ';
                //a346f1a3f8ef9650581483d29e5eaab0:
            }
            foreach ($A7c6258649492b26d77c75c60c793409 as $output_key => $cd7bafd64552e6ca58318f09800cbddd) {
                if (($output_key == 'mp4')) { 
                    $stream['stream_info']['transcode_attributes']['-scodec'] = 'mov_text';
                } else if ($output_key == 'mkv') {
                    $stream['stream_info']['transcode_attributes']['-scodec'] = 'srt';
                } else {
                    //dbac771c7bb31b3cafe5bd4906c9b6b4:
                    $stream['stream_info']['transcode_attributes']['-scodec'] = 'copy';
                    //goto b846d8cb5c86b6cf1d81683bcfa1c327;
                }
                $af428179032a83d9ec1df565934b1c89 .= implode(' ', self::F6664c80BDe3e9bbe2c12CEb906D5A11($stream['stream_info']['transcode_attributes'])) . ' ';
                $af428179032a83d9ec1df565934b1c89 .= $cd7bafd64552e6ca58318f09800cbddd;
            }
            
            $af428179032a83d9ec1df565934b1c89 .= ' >/dev/null 2>' . MOVIES_PATH . $stream_id . '.errors & echo $! > ' . MOVIES_PATH . $stream_id . '_.pid';
            $af428179032a83d9ec1df565934b1c89 = str_replace(array('{FETCH_OPTIONS}', '{STREAM_SOURCE}', '{READ_NATIVE}'), array(empty($be9f906faa527985765b1d8c897fb13a) ? '' : $be9f906faa527985765b1d8c897fb13a, $ed147a39fb35be93248b6f1c206a8023, empty($stream['stream_info']['custom_ffmpeg']) ? $feb3f2070e6ccf961f6265281e875b1a : ''), $af428179032a83d9ec1df565934b1c89);
            //ad99fe107711832dc41ace2638e12a08:
            $af428179032a83d9ec1df565934b1c89 = "ln -s \"{$ed147a39fb35be93248b6f1c206a8023}\" " . MOVIES_PATH . $stream_id . '.' . pathinfo($ed147a39fb35be93248b6f1c206a8023, PATHINFO_EXTENSION) . ' >/dev/null 2>/dev/null & echo $! > ' . MOVIES_PATH . $stream_id . '_.pid';
            //b51196ced3db1f3201f17e394565a638:
            shell_exec($af428179032a83d9ec1df565934b1c89);
            file_put_contents('/tmp/commands', $af428179032a83d9ec1df565934b1c89 . '
', FILE_APPEND);
            $pid = intval(file_get_contents(MOVIES_PATH . $stream_id . '_.pid'));
            self::$ipTV_db->query('UPDATE `streams_sys` SET `to_analyze` = 1,`stream_started` = \'%d\',`stream_status` = 0,`pid` = \'%d\' WHERE `stream_id` = \'%d\' AND `server_id` = \'%d\'', time(), $pid, $stream_id, SERVER_ID);
            return $pid;
            }
        
    }
    static function CEBeee6A9C20e0da24C41A0247cf1244($stream_id, &$bb1b9dfc97454460e165348212675779, $B71703fbd9f237149967f9ac3c41dc19 = null)
    {
        ++$bb1b9dfc97454460e165348212675779;
        if (file_exists(STREAMS_PATH . $stream_id . '_.pid')) {
            unlink(STREAMS_PATH . $stream_id . '_.pid');
        }
        $stream = array();
        self::$ipTV_db->query('SELECT * FROM `streams` t1 
                               INNER JOIN `streams_types` t2 ON t2.type_id = t1.type AND t2.live = 1
                               LEFT JOIN `transcoding_profiles` t4 ON t1.transcode_profile_id = t4.profile_id 
                               WHERE t1.direct_source = 0 AND t1.id = \'%d\'', $stream_id);
        if (self::$ipTV_db->num_rows() <= 0) {
            return false;
        }
        $stream['stream_info'] = self::$ipTV_db->get_row();
        self::$ipTV_db->query('SELECT * FROM `streams_sys` WHERE stream_id  = \'%d\' AND `server_id` = \'%d\'', $stream_id, SERVER_ID);
        if (self::$ipTV_db->num_rows() <= 0) {
            return false;
        }
        $stream['server_info'] = self::$ipTV_db->get_row();
        self::$ipTV_db->query('SELECT t1.*, t2.* FROM `streams_options` t1, `streams_arguments` t2 WHERE t1.stream_id = \'%d\' AND t1.argument_id = t2.id', $stream_id);
        $stream['stream_arguments'] = self::$ipTV_db->get_rows();
        if ($stream['server_info']['on_demand'] == 1) {
            $E1be7e0ba659254273dc1475ae9679e0 = $stream['stream_info']['probesize_ondemand'];
            $C359d5e5ab36c7a88fca0754166e7996 = '10000000';
        } else {
            $C359d5e5ab36c7a88fca0754166e7996 = abs(intval(ipTV_lib::$settings['stream_max_analyze']));
            $E1be7e0ba659254273dc1475ae9679e0 = abs(intval(ipTV_lib::$settings['probesize']));
        }
        $d1c5b35a94aa4152ee37c6cfedfb2ec3 = intval($C359d5e5ab36c7a88fca0754166e7996 / 1000000) + 7;
        $Fa28e3498375fc4da68f3f818d774249 = "/usr/bin/timeout {$d1c5b35a94aa4152ee37c6cfedfb2ec3}s " . FFPROBE_PATH . " {FETCH_OPTIONS} -probesize {$E1be7e0ba659254273dc1475ae9679e0} -analyzeduration {$C359d5e5ab36c7a88fca0754166e7996} {CONCAT} -i \"{STREAM_SOURCE}\" -v quiet -print_format json -show_streams -show_format";
        $be9f906faa527985765b1d8c897fb13a = array();
        if ($stream['server_info']['parent_id'] == 0) {
            $A733a5416ffab6ff47547550f3f9f641 = $stream['stream_info']['type_key'] == 'created_live' ? array(CREATED_CHANNELS . $stream_id . '_.list') : json_decode($stream['stream_info']['stream_source'], true);
        } else {
            $A733a5416ffab6ff47547550f3f9f641 = array(ipTV_lib::$StreamingServers[$stream['server_info']['parent_id']]['site_url_ip'] . 'streaming/admin_live.php?stream=' . $stream_id . '&password=' . ipTV_lib::$settings['live_streaming_pass'] . '&extension=ts');
        }
        if (count($A733a5416ffab6ff47547550f3f9f641) > 0) {
            if (empty($B71703fbd9f237149967f9ac3c41dc19)) {
                if (ipTV_lib::$settings['priority_backup'] != 1) {
                     $A733a5416ffab6ff47547550f3f9f641 = array($B71703fbd9f237149967f9ac3c41dc19);
                }
                else if (!empty($stream['server_info']['current_source'])) {
                    $k = array_search($stream['server_info']['current_source'], $A733a5416ffab6ff47547550f3f9f641);
                    if ($k !== false) {
                        $index = 0;
                        //B1fcf06a1d6da24af4b5d7d516d25b90:
                        while ($index <= $k) {
                            $Ad110d626a9e62f0778a8f19383a0613 = $A733a5416ffab6ff47547550f3f9f641[$index];
                            unset($A733a5416ffab6ff47547550f3f9f641[$index]);
                            array_push($A733a5416ffab6ff47547550f3f9f641, $Ad110d626a9e62f0778a8f19383a0613);
                            $index++;
                        }
                        //a4b738a847141a984c3ba7e300b24bc3:
                        $A733a5416ffab6ff47547550f3f9f641 = array_values($A733a5416ffab6ff47547550f3f9f641);
                    }
                }
                //Cc9dcf3a82486cdcbe22b0df03cd3043:
                //goto ac8a864b3489c444d14e1904ec5dfd7e;

                //Addf182f86a94b305381bd0e81174f08:
                $F7b03a1f7467c01c6ea18452d9a5202f = $bb1b9dfc97454460e165348212675779 <= RESTART_TAKE_CACHE ? true : false;
                if (!$F7b03a1f7467c01c6ea18452d9a5202f) {
                    self::($A733a5416ffab6ff47547550f3f9f641);
                }
                foreach ($A733a5416ffab6ff47547550f3f9f641 as $F3803fa85b38b65447e6d438f8e9176a) {
                    $B16ceb354351bfb3944291018578c764 = self::ParseStreamURL($F3803fa85b38b65447e6d438f8e9176a);
                    $server_protocol = strtolower(substr($B16ceb354351bfb3944291018578c764, 0, strpos($B16ceb354351bfb3944291018578c764, '://')));
                    $be9f906faa527985765b1d8c897fb13a = implode(' ', self::Ea860c1d3851C46D06E64911E3602768($stream['stream_arguments'], $server_protocol, 'fetch'));
                    if ($F7b03a1f7467c01c6ea18452d9a5202f && file_exists(STREAMS_PATH . md5($B16ceb354351bfb3944291018578c764))) {
                        $e49460014c491accfafaa768ea84cd9c = json_decode(file_get_contents(STREAMS_PATH . md5($B16ceb354351bfb3944291018578c764)), true);
                        break;
                    }
                    $e49460014c491accfafaa768ea84cd9c = json_decode(shell_exec(str_replace(array('{FETCH_OPTIONS}', '{CONCAT}', '{STREAM_SOURCE}'), array($be9f906faa527985765b1d8c897fb13a, $stream['stream_info']['type_key'] == 'created_live' && $stream['server_info']['parent_id'] == 0 ? '-safe 0 -f concat' : '', $B16ceb354351bfb3944291018578c764), $Fa28e3498375fc4da68f3f818d774249)), true);
                    if (!empty($e49460014c491accfafaa768ea84cd9c)) {
                        break;
                    }
                }
                if (empty($e49460014c491accfafaa768ea84cd9c)) {
                    if ($stream['server_info']['stream_status'] == 0 || $stream['server_info']['to_analyze'] == 1 || $stream['server_info']['pid'] != -1) {
                        self::$ipTV_db->query('UPDATE `streams_sys` SET `progress_info` = \'\',`to_analyze` = 0,`pid` = -1,`stream_status` = 1 WHERE `server_id` = \'%d\' AND `stream_id` = \'%d\'', SERVER_ID, $stream_id);
                    }
                    return 0;
                }
                if (!$F7b03a1f7467c01c6ea18452d9a5202f) {
                    file_put_contents(STREAMS_PATH . md5($B16ceb354351bfb3944291018578c764), json_encode($e49460014c491accfafaa768ea84cd9c));
                }
                $e49460014c491accfafaa768ea84cd9c = self::Ccbd051c8A19a02dC5B6db256Ae31C07($e49460014c491accfafaa768ea84cd9c);
                $Ee11a0d09ece7de916fbc0b2ca0136a3 = json_decode($stream['stream_info']['external_push'], true);
                $e1dc30615033011f7166d1950e7036ee = 'http://127.0.0.1:' . ipTV_lib::$StreamingServers[SERVER_ID]['http_broadcast_port'] . "/progress.php?stream_id={$stream_id}";
                if (empty($stream['stream_info']['custom_ffmpeg'])) {
                    $af428179032a83d9ec1df565934b1c89 = FFMPEG_PATH . " -y -nostdin -hide_banner -loglevel warning -err_detect ignore_err {FETCH_OPTIONS} {GEN_PTS} {READ_NATIVE} -probesize {$E1be7e0ba659254273dc1475ae9679e0} -analyzeduration {$C359d5e5ab36c7a88fca0754166e7996} -progress \"{$e1dc30615033011f7166d1950e7036ee}\" {CONCAT} -i \"{STREAM_SOURCE}\" ";
                    if (($stream['stream_info']['stream_all'] == 1)) {
                        $fd85ae68a4de5cc6cec54942d82e8f80 = '-map 0 -copy_unknown ';
                    }
                    else if (empty($stream['stream_info']['custom_map'])) {
                        $fd85ae68a4de5cc6cec54942d82e8f80 = $stream['stream_info']['custom_map'] . ' -copy_unknown ';
                    }
                    if ($stream['stream_info']['type_key'] == 'radio_streams') {
                        $fd85ae68a4de5cc6cec54942d82e8f80 = '-map 0:a? ';
                    } else {
                        $fd85ae68a4de5cc6cec54942d82e8f80 = '';
                        //a3b24b9d2c6ec66fd6278ba77698c80f:
                        
                        //goto F7052b7340617388b1314ad99c08b3b6;
                        //Dc744fb7e990d5b473a8aa9a3c2427cb:
                        
                        //goto F7052b7340617388b1314ad99c08b3b6;
                    }
                    
                    if (($stream['stream_info']['gen_timestamps'] == 1 || empty($server_protocol)) && $stream['stream_info']['type_key'] != 'created_live') {
                        $e9652f3db39531a69b91900690d5d064 = '-fflags +genpts -async 1';
                    } else {
                        $e9652f3db39531a69b91900690d5d064 = '-nofix_dts -start_at_zero -copyts -vsync 0 -correct_ts_overflow 0 -avoid_negative_ts disabled -max_interleave_delta 0';
                    }
                    $feb3f2070e6ccf961f6265281e875b1a = '';
                    if ($stream['server_info']['parent_id'] == 0 && ($stream['stream_info']['read_native'] == 1 or stristr($e49460014c491accfafaa768ea84cd9c['container'], 'hls') or empty($server_protocol) or stristr($e49460014c491accfafaa768ea84cd9c['container'], 'mp4') or stristr($e49460014c491accfafaa768ea84cd9c['container'], 'matroska'))) {
                        $feb3f2070e6ccf961f6265281e875b1a = '-re';
                    }
                    if ($stream['server_info']['parent_id'] == 0 and $stream['stream_info']['enable_transcode'] == 1 and $stream['stream_info']['type_key'] != 'created_live') {
                        if ($stream['stream_info']['transcode_profile_id'] == -1) {
                            $stream['stream_info']['transcode_attributes'] = array_merge(self::EA860c1D3851c46d06E64911E3602768($stream['stream_arguments'], $server_protocol, 'transcode'), json_decode($stream['stream_info']['transcode_attributes'], true));
                        } else {
                            $stream['stream_info']['transcode_attributes'] = json_decode($stream['stream_info']['profile_options'], true);
                        }
                    } else {
                        $stream['stream_info']['transcode_attributes'] = array();
                    }
                    if (!array_key_exists('-acodec', $stream['stream_info']['transcode_attributes'])) {
                        $stream['stream_info']['transcode_attributes']['-acodec'] = 'copy';
                    }
                    if (!array_key_exists('-vcodec', $stream['stream_info']['transcode_attributes'])) {
                        $stream['stream_info']['transcode_attributes']['-vcodec'] = 'copy';
                    }
                    if (!array_key_exists('-scodec', $stream['stream_info']['transcode_attributes'])) {
                        $stream['stream_info']['transcode_attributes']['-scodec'] = 'copy';
                    }
                    //f38db3d39bb5dbf7da7a81bff51d7b2d:
                    $A7c6258649492b26d77c75c60c793409 = array();
                    $A7c6258649492b26d77c75c60c793409['mpegts'][] = '{MAP} -individual_header_trailer 0 -f segment -segment_format mpegts -segment_time ' . ipTV_lib::$SegmentsSettings['seg_time'] . ' -segment_list_size ' . ipTV_lib::$SegmentsSettings['seg_list_size'] . ' -segment_format_options "mpegts_flags=+initial_discontinuity:mpegts_copyts=1" -segment_list_type m3u8 -segment_list_flags +live+delete -segment_list "' . STREAMS_PATH . $stream_id . '_.m3u8" "' . STREAMS_PATH . $stream_id . '_%d.ts" ';
                    if ($stream['stream_info']['rtmp_output'] == 1) {
                        $A7c6258649492b26d77c75c60c793409['flv'][] = '{MAP} {AAC_FILTER} -f flv rtmp://127.0.0.1:' . ipTV_lib::$StreamingServers[$stream['server_info']['server_id']]['rtmp_port'] . "/live/{$stream_id} ";
                    }
                    if (!empty($Ee11a0d09ece7de916fbc0b2ca0136a3[SERVER_ID])) {
                        foreach ($Ee11a0d09ece7de916fbc0b2ca0136a3[SERVER_ID] as $b202bc9c1c41da94906c398ceb9f3573) {
                            $A7c6258649492b26d77c75c60c793409['flv'][] = "{MAP} {AAC_FILTER} -f flv \"{$b202bc9c1c41da94906c398ceb9f3573}\" ";
                            //Ee0e2900c8be326931f488fb9c274dea:
                        }
                    }
                    $f32785b2a16d0d92cda0b44ed436f505 = 0;
                    if (!($stream['stream_info']['delay_minutes'] > 0 && $stream['server_info']['parent_id'] == 0)) {
                        foreach ($A7c6258649492b26d77c75c60c793409 as $output_key => $f72c3a34155eca511d79ca3671e1063f) {
                            foreach ($f72c3a34155eca511d79ca3671e1063f as $cd7bafd64552e6ca58318f09800cbddd) {
                                $af428179032a83d9ec1df565934b1c89 .= implode(' ', self::f6664c80bde3e9BBe2c12ceb906d5a11($stream['stream_info']['transcode_attributes'])) . ' ';
                                $af428179032a83d9ec1df565934b1c89 .= $cd7bafd64552e6ca58318f09800cbddd;
                            }
                        }
                    } else {
                        $ccac9556cf5f7f83df650c022d673042 = 0;
                        if (file_exists(DELAY_STREAM . $stream_id . '_.m3u8')) {
                            $Ca434bcc380e9dbd2a3a588f6c32d84f = file(DELAY_STREAM . $stream_id . '_.m3u8');
                            if (stristr($Ca434bcc380e9dbd2a3a588f6c32d84f[count($Ca434bcc380e9dbd2a3a588f6c32d84f) - 1], $stream_id . '_')) {
                                if (preg_match('/\\_(.*?)\\.ts/', $Ca434bcc380e9dbd2a3a588f6c32d84f[count($Ca434bcc380e9dbd2a3a588f6c32d84f) - 1], $ae37877cee3bc97c8cfa6ec5843993ed)) {
                                    $ccac9556cf5f7f83df650c022d673042 = intval($ae37877cee3bc97c8cfa6ec5843993ed[1]) + 1;
                                }
                            } else {
                                if (preg_match('/\\_(.*?)\\.ts/', $Ca434bcc380e9dbd2a3a588f6c32d84f[count($Ca434bcc380e9dbd2a3a588f6c32d84f) - 2], $ae37877cee3bc97c8cfa6ec5843993ed)) {
                                    $ccac9556cf5f7f83df650c022d673042 = intval($ae37877cee3bc97c8cfa6ec5843993ed[1]) + 1;
                                }
                            }
                            if (file_exists(DELAY_STREAM . $stream_id . '_.m3u8_old')) {
                                file_put_contents(DELAY_STREAM . $stream_id . '_.m3u8_old', file_get_contents(DELAY_STREAM . $stream_id . '_.m3u8_old') . file_get_contents(DELAY_STREAM . $stream_id . '_.m3u8'));
                                shell_exec('sed -i \'/EXTINF\\|.ts/!d\' ' . DELAY_STREAM . $stream_id . '_.m3u8_old');
                            } else {
                                copy(DELAY_STREAM . $stream_id . '_.m3u8', DELAY_STREAM . $stream_id . '_.m3u8_old');
                            }
                        }
                        $af428179032a83d9ec1df565934b1c89 .= implode(' ', self::f6664C80BDe3E9bbe2c12ceB906D5A11($stream['stream_info']['transcode_attributes'])) . ' ';
                        $af428179032a83d9ec1df565934b1c89 .= '{MAP} -individual_header_trailer 0 -f segment -segment_format mpegts -segment_time ' . ipTV_lib::$SegmentsSettings['seg_time'] . ' -segment_list_size ' . $stream['stream_info']['delay_minutes'] * 6 . " -segment_start_number {$ccac9556cf5f7f83df650c022d673042} -segment_format_options \"mpegts_flags=+initial_discontinuity:mpegts_copyts=1\" -segment_list_type m3u8 -segment_list_flags +live+delete -segment_list \"" . DELAY_STREAM . $stream_id . '_.m3u8" "' . DELAY_STREAM . $stream_id . '_%d.ts" ';
                        $Dedb93a1e8822879d8790c1f2fc7d6f1 = $stream['stream_info']['delay_minutes'] * 60;
                        if ($ccac9556cf5f7f83df650c022d673042 > 0) {
                            $Dedb93a1e8822879d8790c1f2fc7d6f1 -= ($ccac9556cf5f7f83df650c022d673042 - 1) * 10;
                            if ($Dedb93a1e8822879d8790c1f2fc7d6f1 <= 0) {
                                $Dedb93a1e8822879d8790c1f2fc7d6f1 = 0;
                            }
                        }
                    }
                    $af428179032a83d9ec1df565934b1c89 .= ' >/dev/null 2>>' . STREAMS_PATH . $stream_id . '.errors & echo $! > ' . STREAMS_PATH . $stream_id . '_.pid';
                    $af428179032a83d9ec1df565934b1c89 = str_replace(array('{INPUT}', '{FETCH_OPTIONS}', '{GEN_PTS}', '{STREAM_SOURCE}', '{MAP}', '{READ_NATIVE}', '{CONCAT}', '{AAC_FILTER}'), array("\"{$B16ceb354351bfb3944291018578c764}\"", empty($stream['stream_info']['custom_ffmpeg']) ? $be9f906faa527985765b1d8c897fb13a : '', empty($stream['stream_info']['custom_ffmpeg']) ? $e9652f3db39531a69b91900690d5d064 : '', $B16ceb354351bfb3944291018578c764, empty($stream['stream_info']['custom_ffmpeg']) ? $fd85ae68a4de5cc6cec54942d82e8f80 : '', empty($stream['stream_info']['custom_ffmpeg']) ? $feb3f2070e6ccf961f6265281e875b1a : '', $stream['stream_info']['type_key'] == 'created_live' && $stream['server_info']['parent_id'] == 0 ? '-safe 0 -f concat' : '', !stristr($e49460014c491accfafaa768ea84cd9c['container'], 'flv') && $e49460014c491accfafaa768ea84cd9c['codecs']['audio']['codec_name'] == 'aac' && $stream['stream_info']['transcode_attributes']['-acodec'] == 'copy' ? '-bsf:a aac_adtstoasc' : ''), $af428179032a83d9ec1df565934b1c89);
                    shell_exec($af428179032a83d9ec1df565934b1c89);
                    $pid = $D90a38f0f1d7f1bcd1b2eee088e76aca = intval(file_get_contents(STREAMS_PATH . $stream_id . '_.pid'));
                    if (SERVER_ID == $stream['stream_info']['tv_archive_server_id']) {
                        shell_exec(PHP_BIN . ' ' . TOOLS_PATH . 'archive.php ' . $stream_id . ' >/dev/null 2>/dev/null & echo $!');
                    }
                    $Dac1208baefb5d684938829a3a0e0bc6 = $stream['stream_info']['delay_minutes'] > 0 && $stream['server_info']['parent_id'] == 0 ? true : false;
                    $f32785b2a16d0d92cda0b44ed436f505 = $Dac1208baefb5d684938829a3a0e0bc6 ? time() + $Dedb93a1e8822879d8790c1f2fc7d6f1 : 0;
                    self::$ipTV_db->query('UPDATE `streams_sys` SET `delay_available_at` = \'%d\',`to_analyze` = 0,`stream_started` = \'%d\',`stream_info` = \'%s\',`stream_status` = 0,`pid` = \'%d\',`progress_info` = \'%s\',`current_source` = \'%s\' WHERE `stream_id` = \'%d\' AND `server_id` = \'%d\'', $f32785b2a16d0d92cda0b44ed436f505, time(), json_encode($e49460014c491accfafaa768ea84cd9c), $pid, json_encode(array()), $F3803fa85b38b65447e6d438f8e9176a, $stream_id, SERVER_ID);
                    $playlist = !$Dac1208baefb5d684938829a3a0e0bc6 ? STREAMS_PATH . $stream_id . '_.m3u8' : DELAY_STREAM . $stream_id . '_.m3u8';
                    return array('main_pid' => $pid, 'stream_source' => $B16ceb354351bfb3944291018578c764, 'delay_enabled' => $Dac1208baefb5d684938829a3a0e0bc6, 'parent_id' => $stream['server_info']['parent_id'], 'delay_start_at' => $f32785b2a16d0d92cda0b44ed436f505, 'playlist' => $playlist);
                
                    
                } else {
                    $stream['stream_info']['transcode_attributes'] = array();
                    $af428179032a83d9ec1df565934b1c89 = FFMPEG_PATH . " -y -nostdin -hide_banner -loglevel quiet {$d1006c7cc041221972025137b5112b7d} -progress \"{$e1dc30615033011f7166d1950e7036ee}\" " . $stream['stream_info']['custom_ffmpeg'];
                }
            }
        }
    }
    public static function customOrder($D099d64305e0e1b9f20300f1ef51f8a7, $E28f7a505c062145e6df747991c0a2d3)
    {
        if (substr($D099d64305e0e1b9f20300f1ef51f8a7, 0, 3) == '-i ') {
            return -1;
        }
        return 1;
    }
    public static function EA860c1D3851C46d06E64911E3602768($c31311861794ebdea68a9eab6a24fd6d, $server_protocol, $type)
    {
        $Eb6e347d24315f277ac38240a6589dd0 = array();
        if (!empty($c31311861794ebdea68a9eab6a24fd6d)) {
            foreach ($c31311861794ebdea68a9eab6a24fd6d as $f091df572e6d2b79881acbf4e5500a7e => $e380987e83a27088358f65f47ff3117f) {
                if ($e380987e83a27088358f65f47ff3117f['argument_cat'] != $type) {
                    continue;
                }
                if (!is_null($e380987e83a27088358f65f47ff3117f['argument_wprotocol']) && !stristr($server_protocol, $e380987e83a27088358f65f47ff3117f['argument_wprotocol']) && !is_null($server_protocol)) {
                    continue;
                }
                if ($e380987e83a27088358f65f47ff3117f['argument_type'] == 'text') {
                    $Eb6e347d24315f277ac38240a6589dd0[] = sprintf($e380987e83a27088358f65f47ff3117f['argument_cmd'], $e380987e83a27088358f65f47ff3117f['value']);
                } else {
                    $Eb6e347d24315f277ac38240a6589dd0[] = $e380987e83a27088358f65f47ff3117f['argument_cmd'];
                }
                //e0ffb06cc49d2710bde0e13e6fb02e4c:
            }
        }
        return $Eb6e347d24315f277ac38240a6589dd0;
    }
    public static function F6664c80bdE3E9BBe2C12CeB906D5a11($Bddd92df0619e485304556731bb7ca2f)
    {
        $e80cbed8655f14b141bd53699dbbdc10 = array();
        foreach ($Bddd92df0619e485304556731bb7ca2f as $k => $e380987e83a27088358f65f47ff3117f) {
            if (isset($e380987e83a27088358f65f47ff3117f['cmd'])) {
                $Bddd92df0619e485304556731bb7ca2f[$k] = $e380987e83a27088358f65f47ff3117f = $e380987e83a27088358f65f47ff3117f['cmd'];
            }
            if (preg_match('/-filter_complex "(.*?)"/', $e380987e83a27088358f65f47ff3117f, $ae37877cee3bc97c8cfa6ec5843993ed)) {
                $Bddd92df0619e485304556731bb7ca2f[$k] = trim(str_replace($ae37877cee3bc97c8cfa6ec5843993ed[0], '', $Bddd92df0619e485304556731bb7ca2f[$k]));
                $e80cbed8655f14b141bd53699dbbdc10[] = $ae37877cee3bc97c8cfa6ec5843993ed[1];
            }
        }
        if (!empty($e80cbed8655f14b141bd53699dbbdc10)) {
            $Bddd92df0619e485304556731bb7ca2f[] = '-filter_complex "' . implode(',', $e80cbed8655f14b141bd53699dbbdc10) . '"';
        }
        $B54918193a6b3b39c547eb9486c4c2ff = array();
        foreach ($Bddd92df0619e485304556731bb7ca2f as $k => $e7ddd0b219bd2e9b7547185c8bccb6a9) {
            if (is_numeric($k)) {
                $B54918193a6b3b39c547eb9486c4c2ff[] = $e7ddd0b219bd2e9b7547185c8bccb6a9;
            } else {
                $B54918193a6b3b39c547eb9486c4c2ff[] = $k . ' ' . $e7ddd0b219bd2e9b7547185c8bccb6a9;
            }
        }
        $B54918193a6b3b39c547eb9486c4c2ff = array_filter($B54918193a6b3b39c547eb9486c4c2ff);
        uasort($B54918193a6b3b39c547eb9486c4c2ff, array(__CLASS__, 'customOrder'));
        return array_map('trim', array_values(array_filter($B54918193a6b3b39c547eb9486c4c2ff)));
    }
    public static function ParseStreamURL($D849b6918b9e10195509dc8a824f49eb)
    {
        $server_protocol = strtolower(substr($D849b6918b9e10195509dc8a824f49eb, 0, 4));
        if (($server_protocol == 'rtmp')) {
            //C619dc15ff5a81c707d839f9e063654f:
            if (stristr($D849b6918b9e10195509dc8a824f49eb, '$OPT')) {
                $b853b956930a081396b7a6beb8404265 = 'rtmp://$OPT:rtmp-raw=';
                $D849b6918b9e10195509dc8a824f49eb = trim(substr($D849b6918b9e10195509dc8a824f49eb, stripos($D849b6918b9e10195509dc8a824f49eb, $b853b956930a081396b7a6beb8404265) + strlen($b853b956930a081396b7a6beb8404265)));
            }
            $D849b6918b9e10195509dc8a824f49eb .= ' live=1 timeout=10';
            //goto A241a8d3b9b9be4b98784fded18f7b85;
        }
        else if ($server_protocol == 'http') {
            $d412be7a00d131e9be20aca9526c741f = array('youtube.com', 'youtu.be', 'livestream.com', 'ustream.tv', 'twitch.tv', 'vimeo.com', 'facebook.com', 'dailymotion.com', 'cnn.com', 'edition.cnn.com', 'youporn.com', 'pornhub.com', 'youjizz.com', 'xvideos.com', 'redtube.com', 'ruleporn.com', 'pornotube.com', 'skysports.com', 'screencast.com', 'xhamster.com', 'pornhd.com', 'pornktube.com', 'tube8.com', 'vporn.com', 'giniko.com', 'xtube.com');
            $E8cb364637af05312e9ad4e7c0680ce2 = str_ireplace('www.', '', parse_url($D849b6918b9e10195509dc8a824f49eb, PHP_URL_HOST));
            if (in_array($E8cb364637af05312e9ad4e7c0680ce2, $d412be7a00d131e9be20aca9526c741f)) {
                $urls = trim(shell_exec(YOUTUBE_PATH . " \"{$D849b6918b9e10195509dc8a824f49eb}\" -q --get-url --skip-download -f best"));
                $D849b6918b9e10195509dc8a824f49eb = explode('
', $urls)[0];
            }
        }
        return $D849b6918b9e10195509dc8a824f49eb;
    }
}
?>
