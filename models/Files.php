<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "Files".
 *
 * @property int $FileID
 * @property resource $FileData
 * @property string $FileName
 * @property string $FileType
 * @property string $ContentType
 * @property string $FileSize
 * @property int $CreatedBy
 * @property string $CreatedAt
 */
class Files extends \yii\db\ActiveRecord
{
    public $fileInput;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class, //
                'createdAtAttribute' => 'CreatedAt', //
                'updatedAtAttribute' => null, //
                'value' => date('Y-m-d H:i:s'),
            ],
            'blamable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'CreatedBy',
                'updatedByAttribute' => null,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fileInput'], 'required'],
            [['FileData', 'FileName', 'FileType'], 'string'],
            [['CreatedBy', 'FileSize'], 'integer'],
            [['CreatedAt'], 'safe'],
            [['FileName', 'FileType', 'ContentType'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'FileID' => 'File ID',
            'FileData' => 'File Data',
            'FileName' => 'File Name',
            'FileType' => 'File Type',
            'ContentType' => 'Content Type',
            'FileSize' => 'File Size',
            'CreatedBy' => 'Created By',
            'CreatedAt' => 'Created At',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $fileData = file_get_contents($this->fileInput->tempName);
            $this->FileData = $fileData;
            $this->FileName = $this->fileInput->name;
            $this->FileType = $this->fileInput->extension;
            $this->ContentType = $this->fileInput->type;
            $this->FileSize = $this->fileInput->size;
            if (!$this->save()) {
                print_r('<pre>');
                print_r($this->fileInput->size) . exit();
            } else {
                $this->save();
                return $this->FileID;
            }
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     * @return DocumentsTableQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FilesQuery(get_called_class());
    }
}
