#!/usr/bin/python2

import sys
import re
import json
from datetime import datetime
try:
    import telnetlib
    import MySQLdb
except ImportError:
    print 'Cannot import telnetlib and/or MySQLdb.'
    sys.exit(1)

__username__ = 'CENSORED'
__password__ = 'CENSORED'

def run():
    conn = MySQLdb.connect(host='CENSORED', user='CENSORED', passwd='CENSORED', db='CENSORED')
    PROMPT1 = 'CLI>'
    PROMPT2 = 'CLI#'
    PROMPT3 = '# '

    tn = telnetlib.Telnet('CENSORED')
    tn.read_until('Username:')
    tn.write(__username__ + '\n')
    tn.read_until('Password:')
    tn.write(__password__ + '\n')
    tn.read_until(PROMPT1)
    tn.write('enable\n')
    tn.read_until('Password:')
    tn.write('zte\n')
    tn.read_until(PROMPT2)
    tn.write('shell\n')
    tn.read_until('Login: ')
    tn.write('root\n')
    tn.read_until('Password: ')
    tn.write('root\n')
    tn.read_until(PROMPT3)
    tn.write('xdslctl info --stats\n') # Grab stats
    stats = tn.read_until(PROMPT3)
    tn.write('xdslctl info --pbParams\n')
    pb_params = tn.read_until(PROMPT3) # Grab pbParams
    tn.write('xdslctl info --vendor\n')
    vendor = tn.read_until(PROMPT3) # Grab Vendor
    tn.write('ifconfig ppp0\n')
    ppp0_ip = tn.read_until(PROMPT3) # Grab ppp0_ip
    tn.write('free\n')
    ram = tn.read_until(PROMPT3) # Grab RAM
    tn.write('ifconfig ptm\n')
    ptm = tn.read_until(PROMPT3) # Grab PTM interface crap
    tn.write('cat /proc/uptime\n')
    uptime = tn.read_until(PROMPT3) # Grab uptime
    tn.write('cat /proc/version\n')
    version = tn.read_until(PROMPT3) # Grab OS version
    tn.write('cat /proc/loadavg\n') # Grab loadavg
    loadavg = tn.read_until(PROMPT3)
    tn.write('exit\n')
    tn.close()

    # Stats
    r_general = re.findall('Mode:\s(.*)\nVDSL2\sProfile:\s(.*)\nTPS-TC:\s(.*)\nTrellis:\s(.*)\nLine Status:\s(.*)\nTraining Status:\s(.*)', stats, re.IGNORECASE|re.MULTILINE)
    r_pbStats = re.findall('Since Link time = (.*)\nFEC:\s(.*)\nCRC:\s(.*)\nES:\s(.*)\nSES:\s(.*)\nUAS:\s(.*)\nLOS:\s(.*)\nLOF:\s(.*)\nLOM:\s(.*)', stats, re.IGNORECASE|re.MULTILINE)

    # pbStats
    r_lineAttenuation   = ','.join([str(i) for i in re.findall('Line Attenuation\(dB\):\s*([0-9.]*)\s*([0-9.]*)\s*([0-9.]*)\s*N\/A\s*([0-9.]*)\s*([0-9.]*)\s*([0-9.]*)', pb_params, re.IGNORECASE|re.MULTILINE)[0]])
    r_signalAttenuation = ','.join([str(i) for i in re.findall('Signal Attenuation\(dB\):\s*([0-9.]*)\s*([0-9.]*)\s*([0-9.]*)\s*N\/A\s*([0-9.]*)\s*([0-9.]*)\s*([0-9.]*)', pb_params, re.IGNORECASE|re.MULTILINE)[0]])
    r_snrmargin         = ','.join([str(i) for i in re.findall('SNR Margin\(dB\):\s*([0-9.]*)\s*([0-9.]*)\s*([0-9.]*)\s*N\/A\s*([0-9.]*)\s*([0-9.]*)\s*([0-9.]*)', pb_params, re.IGNORECASE|re.MULTILINE)[0]])
    r_txpower           = ','.join([str(i) for i in re.findall('TX Power\(dBm\):\s*([0-9.-]*)\s*([0-9.-]*)\s*([0-9.-]*)\s*N\/A\s*([0-9.-]*)\s*([0-9.-]*)\s*([0-9.-]*)', pb_params, re.IGNORECASE|re.MULTILINE)[0]])
    r_attainable        = ','.join([str(i) for i in re.findall('Attainable Net Data Rate:\s*([0-9]*)\skbps\s*([0-9]*)\skbps', pb_params, re.IGNORECASE|re.MULTILINE)[0]])
    r_actual            = ','.join([str(i) for i in re.findall('Bearer: 0, Upstream rate = ([0-9]*) Kbps, Downstream rate = ([0-9]*) Kbps', pb_params, re.IGNORECASE|re.MULTILINE)[0]])
    r_actualtx          = ','.join([str(i) for i in re.findall('Actual Aggregate Tx Power:\s*([0-9.-]*)\sdBm\s*([0-9.-]*)\sdBm', pb_params, re.IGNORECASE|re.MULTILINE)[0]])

    # Etc
    r_vendor  = re.findall('ChipSet Vendor Id:\s(.*)', vendor, re.IGNORECASE|re.MULTILINE)
    r_ppp0_ip = re.findall('inet addr:([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}.[0-9]{1,3})', ppp0_ip, re.IGNORECASE|re.MULTILINE)
    r_ram     = re.findall('Total:\s+([0-9]*)\s+([0-9]*)\s+([0-9]*)', ram, re.IGNORECASE|re.MULTILINE)
    r_ptm     = re.findall('RX bytes:[0-9]*\s\(([0-9\.]*)\s\w+\)\s+TX bytes:[0-9]*\s\(([0-9\.]*)\s\w+\)', ptm, re.IGNORECASE|re.MULTILINE)
    r_uptime  = re.findall('([0-9\.]*)\s([0-9\.]*)', uptime, re.IGNORECASE|re.MULTILINE)
    r_version = re.findall('(.*)', version, re.IGNORECASE|re.MULTILINE)
    r_loadavg = re.findall('(.*)', loadavg, re.IGNORECASE|re.MULTILINE)

    """print r_vendor[0].strip() # vendor ok
    print r_ram[0][0] # total
    print r_ram[0][1] # used
    print r_ram[0][2] # free
    print r_ppp0_ip[0]  # ok IP
    print r_ptm[0][0] # OK down rx
    print r_ptm[0][1] # OK up tx
    print r_uptime[2][1] # OK uptime
    print r_uptime[3][1] # OK idle
    print r_version[2]"""

    cp = conn.cursor()
    try:
        cp.execute("""INSERT INTO stats (mode, vdsl2_profile, tps_tc, trellis, line_status, training_status, errors, raw, created_at, updated_at) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, now(), now())""",(
            r_general[0][0].strip(),
            r_general[0][1].strip(),
            r_general[0][2].strip(),
            r_general[0][3].strip(),
            r_general[0][4].strip(),
            r_general[0][5].strip(),
            json.dumps(r_pbStats),
            stats
        ))
        cp.execute("""INSERT INTO pbStats (line_attenuation, signal_attenuation, snr_margin, tx_power, actual_tx, attainable_rate, actual_rate, created_at, updated_at) VALUES (%s, %s, %s, %s, %s, %s, %s, now(), now())""",(
            r_lineAttenuation,
            r_signalAttenuation,
            r_snrmargin,
            r_txpower,
            r_actualtx,
            r_attainable,
            r_actual
        ))
        cp.execute("""INSERT INTO system (vendor, ppp0_ip, ram_used, ram_free, ptm_rx, ptm_tx, uptime, uname, loadavg, created_at, updated_at) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, now(), now())""",(
            r_vendor[0].strip(),
            r_ppp0_ip[0],
            r_ram[0][1],
            r_ram[0][2],
            r_ptm[0][0],
            r_ptm[0][1],
            r_uptime[2][1],
            r_version[2],
            r_loadavg[2]
        ))
        conn.commit()
    except Exception, e:
        print repr(e)
        print(e)
        conn.rollback()

    conn.close()

if __name__ == '__main__':
    run()
