# captcha_cracker

![](https://github.com/chxj1992/captcha_cracker/raw/master/screenshot.png)

[在线Demo](http://captcha.chxj.name/)

### 简介 

这是一个基于 [Keras](https://keras.io/) 编写的卷积神经网络模型，简单实现的验证码识别功能。

[Captcha](https://github.com/mewebstudio/captcha/) 是一款 [Laravel](https://laravel.com) 社区中流行的验证码生成库,
项目模型的训练集以及在线测试所用到的验证码均采用该库生成。 

运行环境 `Ubuntu16.04` `python3.5.2 virtualenv` `Tensorflow Backend` 

### 实现原理

* 用 `Captcha` 生成2组每组2000个4位验证码图片（图片尺寸：36×120），并等分成4份(单张图片尺寸：36×30)，将单个字符的图片分类保存在 `images` 目录中作为训练集（每组8000张图片）。
* 生成2组每组500个4位验证码图片（图片尺寸：36×120），并等分成4份(单张图片尺寸：36×30)，将单个字符的图片分类保存在 `images` 目录中作为测试集（每组2000张图片）。
* 运行 `pack_data.py` 将图片转为 `RGB` 矩阵并用cPickle打包为单个文件
* 运行 `train.py` 分别使用两组训练、测试数据对模型进行各100轮的训练，模型权重保存在 `weights.hdf5` 文件中

生成验证码代码样例可参考 [CaptchaGenerator.php](https://github.com/chxj1992/captcha_cracker/blob/master/CaptchaGenerator.php)

