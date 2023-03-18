from __future__ import print_function
import logging
import telebot
from rocketry import Rocketry
from rocketry.conds import daily
import os

logger = logging.getLogger(__name__)
app = Rocketry()

PROJECT_NAME = 'telegrambotmedicine'
TELEGRAM_TOKEN = '<TOKEN>'
CHAT_ID = '<CHAT_ID>'
CYCLE=28
BUCKET='rioaws-app-medicine'
USER='Pietro'
bot = telebot.TeleBot(TELEGRAM_TOKEN)
BASE_PATH='/home/ubuntu'

calendar = {
    #scrivere -1 ora rispetto al server
    #se deve arrivare alle 9:30 scrivere 8:30
    '06:00': 'Esomeprazolo',
    '7:30': 'Antunes',
    '08:30': 'Levantair Spray',
    '9:00': 'Betotal',
    '10:00': 'Mycostatin',
    '13:30': 'Noremifa',
    '14:30': 'Plavix',
    '15:00': 'Mycostatin_2',
    '21:30': 'Mycostatin_3',
    '20:30': 'Noremifa_2',
    '22:00': 'Noremifa_3',
    '22:00': 'Simvastatina',
    }

images = {
    'Mycostatin': 'images/mycostatin.jpeg',
    'Esomeprazolo': 'images/esomeprazolo.jpeg',
    'Betotal': 'images/betotal.jpeg',
    'Plavix': 'images/plavix.jpeg',
    'Levantair Spray': 'images/laventair.jpeg',
    'Noremifa': 'images/noremifa.jpeg',
    'Antunes': 'images/antunes.jpeg',
    'Simvastatina': 'images/Simvastatina.jpeg',
    'Mycostatin_2': 'images/mycostatin.jpeg',
    'Mycostatin_3': 'images/mycostatin.jpeg',
    'Noremifa_2': 'images/noremifa.jpeg',
    'Noremifa_3': 'images/noremifa.jpeg',
    'Simvastatina': 'images/simvastatina.jpeg',
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

def send_image(msg):
    tb = telebot.TeleBot(TELEGRAM_TOKEN)
    image = open(os.path.join(BASE_PATH, images[msg]), 'rb')
    ret_msg = tb.send_photo(CHAT_ID, image)
    assert ret_msg.message_id 

if __name__ == "__main__":
    for event in calendar:
        code_string = '''
@app.task(daily.at(event))
def do_daily_{}():
    test_send_message('{}')
    send_image('{}')
    print('Done daily!')
'''.format(calendar[event].replace(' ', '_'), calendar[event], calendar[event])
        exec(code_string)
    app.run()