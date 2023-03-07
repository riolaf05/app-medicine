from __future__ import print_function
import logging
import telebot
from rocketry import Rocketry
from rocketry.conds import daily

logger = logging.getLogger(__name__)
app = Rocketry()

PROJECT_NAME = 'telegrambotmedicine'
TELEGRAM_TOKEN = ''
CHAT_ID = ''
CYCLE=28
BUCKET='rioaws-app-medicine'
USER='Pietro'
bot = telebot.TeleBot(TELEGRAM_TOKEN)

calendar = {
    '12:10': 'Pillola1',
    '12:12': 'Pillola2',
    '12:13': 'Pillola3',
    '12:14': 'Pillola4',
    }

def test_send_message(msg):
    bot_text = '''
        Bip-bop umano {},

    E' il momento di prendere {}

    Created with ❤️ by Ros
        '''.format(USER, msg)
    tb = telebot.TeleBot(TELEGRAM_TOKEN)
    ret_msg = tb.send_message(CHAT_ID, bot_text)
    assert ret_msg.message_id 

if __name__ == "__main__":
    for event in calendar:
        code_string = '''
@app.task(daily.at(event))
def do_daily_{}():
    test_send_message('{}')
    print('Done daily!')
'''.format(calendar[event].replace(' ', '_'), calendar[event])
        exec(code_string)
    app.run()