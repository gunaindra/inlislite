<?php

namespace common\models;

use Yii;
use \common\models\base\Collections as BaseCollections;

/**
 * This is the model class for table "collections".
 */
class CollectionBiblio extends BaseCollections
{

    public $KataSandang;
    public $JumlahHalaman;
    public $KeteranganIllustrasi;
    public $Dimensi;
    public $CallNumber;
	public $Title;
    public $TitleAdded;
    public $Author;
    public $AuthorType;
    public $AuthorAdded;
    public $AuthorAddedType;
    public $PenanggungJawab;
    public $PublishLocation;
    public $Publisher;
    public $PublishYear;
    public $Edition;
    public $Class;
    public $PhisycalDescription;
    public $ISBN;
    public $ISSN;
    public $Subject;
    public $SubjectTag;
    public $SubjectInd;
    public $Note;
    public $NoteTag;
    public $Bahasa;
    public $BentukKaryaTulis;
    public $KelompokSasaran;
    public $Taglist;
    public $JenisIsi;
    public $JenisMedia;
    public $JenisCarrier;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['Title', 'required'],
            ['PublishYear', 'integer'],
            [['JenisIsi','JenisMedia','JenisCarrier','Author','AuthorAdded','Edition','Class','PhisycalDescription','ISBN','ISSN','Note','TitleAdded','PenanggungJawab','AuthorType','AuthorAddedType','KataSandang','JumlahHalaman','KeteranganIllustrasi','Dimensi','CallNumber','Subject','NoteDisertasi','NoteBibliografi','NoteRincian','NoteAbstraksi','Bahasa','BentukKaryaTulis','KelompokSasaran','SubjectTag','SubjectInd','NoteTag'], 'safe'],
            [['PublishLocation','Publisher','PublishYear'], 'validatePublishment'],
        ];
    }

    function validatePublishment($attribute, $param) {
        if(empty($this->PublishLocation) && empty($this->Publisher) && empty($this->PublishYear))
        $this->addError($attribute, 'Publishment must be fiiled at least one');
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'KataSandang'=>Yii::t('app', 'bib_KataSandang'),
            'Title'=> Yii::t('app', 'bib_Judul'),
            'Author'=> Yii::t('app', 'bib_Pengarang'),
            'PublishLocation'=> Yii::t('app', 'bib_Lokasi terbit'),
            'Publisher'=> Yii::t('app', 'bib_Penerbit'),
            'PublishYear'=> Yii::t('app', 'bib_Tahun terbit'),
            'Edition'=> Yii::t('app', 'bib_Edisi'),
            'Class'=> Yii::t('app', 'bib_Kelas'),
            'PhisycalDescription'=> Yii::t('app', 'bib_Deskripsi Fisik'),
            'ISBN'=> Yii::t('app', 'bib_ISBN'),
            'ISSN'=> Yii::t('app', 'bib_ISSN'),
            'Note'=> Yii::t('app', 'bib_Catatan'),
            'TitleAdded'=> Yii::t('app', 'bib_Anak Judul'),
            'AuthorAdded'=> Yii::t('app', 'bib_Pengarang Tambahan'),
            'PenanggungJawab' => Yii::t('app', 'bib_Penanggung Jawab'),
            'CallNumber'=> Yii::t('app', 'bib_CallNumber'),
            'JumlahHalaman'=> Yii::t('app', 'bib_Jumlah Halaman'),
            'KeteranganIllustrasi'=> Yii::t('app', 'bib_Keterangan Illustrasi'),
            'Dimensi'=> Yii::t('app', 'bib_Dimensi'),
            'Subject'=> Yii::t('app', 'bib_Subject'),
            'NoteDisertasi'=> Yii::t('app', 'bib_Catatan Disertasi'),
            'NoteBibliografi'=> Yii::t('app', 'bib_Catatan Bibliografi'),
            'NoteRincian'=> Yii::t('app', 'bib_Catatan Rincian'),
            'NoteAbstraksi'=> Yii::t('app', 'bib_Catatan Abstraksi'),
            'Bahasa' => Yii::t('app', 'bib_Bahasa'),
            'BentukKaryaTulis' => Yii::t('app', 'bib_BentukKaryaTulis'),
            'KelompokSasaran' => Yii::t('app', 'bib_KelompokSasaran'),
            'SubjectTag' => Yii::t('app', 'bib_SubjectTag'),
            'SubjectInd' => Yii::t('app', 'bib_SubjectInd'),
            'NoteTag' => Yii::t('app', 'bib_NoteTag'),
            'JenisIsi' => Yii::t('app', 'bib_JenisIsi'),
            'JenisMedia' => Yii::t('app', 'bib_JenisMedia'),
            'JenisCarrier' => Yii::t('app', 'bib_JenisCarrier')
        ];
    }
}
