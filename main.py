from __future__ import print_function
import logging
import telebot
from rocketry import Rocketry
from rocketry.conds import daily

logger = logging.getLogger(__name__)
app = Rocketry()

PROJECT_NAME = 'telegrambotmedicine'
TELEGRAM_TOKEN = '<TOKEN>'
CHAT_ID = '<CHAT_ID>'
CYCLE=28
BUCKET='rioaws-app-medicine'
USER='Pietro'
bot = telebot.TeleBot(TELEGRAM_TOKEN)

calendar = {
    '09:00': 'Levantair Spray',
    '09:30': 'Antunes',
    '22:30': 'Sinvastatina',
    '18:00': 'Seleparina'
    }

def test_send_message(msg):
    bot_text = '''
        Buongiorno {},

    E' il momento di prendere: {}

    🩺💊⚕️😷

    Created by Ros
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