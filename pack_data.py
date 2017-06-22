import os

import numpy as np
from PIL import Image
from six.moves import cPickle

image_folder = 'images/train2'
pack_name = 'train2_batch'

classes = '2346789abcdefghjmnpqrtuxyzABCDEFGHJMNPQRTUXYZ'

data = {'data': np.empty(shape=(0, 36, 30, 3), dtype=float), 'labels': np.empty(shape=(0, 1), dtype=int)}

i = 0
print("start packing", image_folder)
for dirname, dirnames, filenames in os.walk(image_folder):
    for filename in filenames:
        if filename.endswith('.png'):
            im = Image.open(os.path.join(dirname, filename))
            arr = np.array(im)
            data['data'] = np.append(data['data'], np.array([arr]), axis=0)

            class_name = os.path.join(dirname).split('/')[-1]
            class_code = np.array([classes.index(str(class_name))])
            data['labels'] = np.append(data['labels'], np.array([class_code]), axis=0)
        i += 1
        if i % 1000 == 0:
            print(i, "data formatted")

cPickle.dump(data, open(pack_name, "wb"))
