from __future__ import print_function

import keras
from six.moves import cPickle

import model as m

batch_size = 32
num_classes = 45
epochs = 100

data_train = cPickle.load(open('train2_batch', "rb"))
data_test = cPickle.load(open('test2_batch', "rb"))

x_train = data_train['data']
y_train = data_train['labels']
x_test = data_test['data']
y_test = data_test['labels']

print('x_train shape:', x_train.shape)
print(x_train.shape[0], 'train samples')
print(x_test.shape[0], 'test samples')

# Convert class vectors to binary class matrices.
y_train = keras.utils.to_categorical(y_train, num_classes)
y_test = keras.utils.to_categorical(y_test, num_classes)

x_train = x_train.astype('float32')
x_test = x_test.astype('float32')
x_train /= 255
x_test /= 255

model = m.build(x_train.shape[1:], num_classes)

model.fit(x_train, y_train,
          batch_size=batch_size,
          epochs=epochs,
          validation_data=(x_test, y_test),
          shuffle=True)

model.save_weights('weights.hdf5')
