<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => ':attribute harus lebih besar dari :date.',
    'after_or_equal' => ':attribute harus lebih besar atau sama dengan :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => ':attribute harus kurang dari :date.',
    'before_or_equal' => ':attribute harus kurang dari atau sama dengan :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'Format :attribute tidak valid.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'Format :attribute harus (:format).',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => ':attribute harus :digits digit.',
    'digits_between' => ':attribute minimal :min dan maksimal :max digit.',
    'dimensions' => ':attribute dimensi tidak valid.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file' => ':attribute tidak boleh lebih besar dari :max KB.',
        'string' => 'The :attribute must not be greater than :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => ':attribute harus berformat : :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => ':attribute harus angka.',
    'password' => ':attribute salah.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => ':attribute harus diisi.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => ':attribute sudah terdaftar.',
    'uploaded' => ':attribute gagal diunggah.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'address'               => 'Alamat',
        'amount'                => 'Nominal',
        'author'                => 'Penulis',
        'birth_date'            => 'Tanggal Lahir',
        'birth_place'           => 'Tempat Lahir',
        'blood_type'            => 'Golongan Darah',
        'category'              => 'Kategori',
        'child_to'              => 'Anak Ke',
        'child_count'           => 'Jumlah Saudara',
        'citizen'               => 'Kewarganegaraan',
        'class'                 => 'Kelas',
        'clazz'                 => 'Kelas',
        'clock_in'              => 'Jam Masuk',
        'clock_out'             => 'Jam Keluar',
        'company_name'          => 'Nama Sekolah',
        'code'                  => 'Kode',
        'description'           => 'Deskripsi',
        'diagnose'              => 'Penyakit',
        'distance'              => 'Jarak Tempuh',
        'extracurricular'       => 'Ekstrakurikuler',
        'family'                => 'Status Keluarga',
        'family_status'         => 'Status Keluarga',
        'father_address'        => 'Alamat Ayah',
        'father_birth_date'     => 'Tanggal Lahir Ayah',
        'father_birth_place'    => 'Tempat Lahir Ayah',
        'father_name'           => 'Nama Ayah',
        'father_home_number'    => 'Nomor Telepon Ayah',
        'father_phone_number'   => 'Nomor HP Ayah',
        'father_citizen'        => 'Kewarganegaraan Ayah',
        'father_last_study'     => 'Pendidikan Terakhir Ayah',
        'father_occupation'     => 'Pekerjaan Ayah',
        'father_revenue'        => 'Penghasilan Ayah',
        'first_study'           => 'Pendidikan Pertama',
        'from_study_date'       => 'Dari Tanggal',
        'full_name'             => 'Nama Lengkap',
        'gender'                => 'Jenis Kelamin',
        'group'                 => 'Kelompok',
        'guardian_address'      => 'Alamat Wali',
        'guardian_birth_date'   => 'Tanggal Lahir Wali',
        'guardian_birth_place'  => 'Tempat Lahir Wali',
        'guardian_name'         => 'Nama Wali',
        'guardian_home_number'  => 'Nomor Telepon Wali',
        'guardian_phone_number' => 'Nomor HP Wali',
        'guardian_citizen'      => 'Kewarganegaraan Wali',
        'guardian_last_study'   => 'Pendidikan Terakhir Wali',
        'guardian_occupation'   => 'Pekerjaan Wali',
        'guardian_revenue'      => 'Penghasilan Wali',
        'height'                => 'Tinggi',
        'home_number'           => 'Nomor Telepon',
        'installment_amount'    => 'Nominal Cicilan',
        'language'              => 'Bahasa',
        'lesson'                => 'Mata Pelajaran',
        'level'                 => 'Tingkatan',
        'min_score'             => 'Nilai Minimal',
        'max_score'             => 'Nilai Maksimal',
        'mother_address'        => 'Alamat Ibu',
        'mother_birth_date'     => 'Tanggal Lahir Ibu',
        'mother_birth_place'    => 'Tempat Lahir Ibu',
        'mother_name'           => 'Nama Ibu',
        'mother_home_number'    => 'Nomor Telepon Ibu',
        'mother_phone_number'   => 'Nomor HP Ibu',
        'mother_citizen'        => 'Kewarganegaraan Ibu',
        'mother_last_study'     => 'Pendidikan Terakhir Ibu',
        'mother_occupation'     => 'Pekerjaan Ibu',
        'mother_revenue'        => 'Penghasilan Ibu',
        'move_from'             => 'Pindah Dari',
        'move_reason'           => 'Alasan Pindah',
        'major'                 => 'Jurusan',
        'name'                  => 'Nama',
        'nik'                   => 'NIK',
        'nis'                   => 'NIS',
        'nip'                   => 'NIP',
        'nisn'                  => 'NISN',
        'kkm'                   => 'Nilai KKM',
        'password'              => 'Kata Sandi',
        'phone_number'          => 'Nomor HP',
        'picture'               => 'Foto/Gambar',
        'photo'                 => 'Foto/Gambar',
        'religion'              => 'Agama',
        'score'                 => 'Nilai',
        'semester'              => 'Semester',
        'start_date'            => 'Tangga Mulai',
        'stepbrother_count'     => 'Jumlah Saudara Tiri',
        'stepsibling_count'     => 'Jumlah Saudara Angkat',
        'sttb_no'               => 'Nomor STTB',
        'student'               => 'Siswa',
        'study'                 => 'Tahun Pelajaran',
        'study_year'            => 'Tahun Pelajaran',
        'to_study_date'         => 'Sampai Tanggal',
        'username'              => 'Nama Pengguna',
        'title'                 => 'Judul',
        'teacher'               => 'Guru',
        'value'                 => 'Nominal',
        'weight'                => 'Berat',
        'year'                  => 'Tahun',
    ],
];
