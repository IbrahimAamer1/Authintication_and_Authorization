<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Certificate of Completion </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'Tahoma', sans-serif;
            background: #f5f5f5;
            padding: 40px;
        }
        
        .certificate-container {
            max-width: 900px;
            margin: 0 auto;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 5px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .certificate-inner {
            background: #ffffff;
            padding: 60px 50px;
            border-radius: 15px;
            text-align: center;
            position: relative;
        }
        
        .certificate-header {
            margin-bottom: 40px;
        }
        
        .certificate-title {
            font-size: 48px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .certificate-subtitle {
            font-size: 24px;
            color: #764ba2;
            margin-bottom: 50px;
        }
        
        .certificate-body {
            margin: 50px 0;
        }
        
        .certificate-text {
            font-size: 20px;
            color: #333;
            line-height: 1.8;
            margin-bottom: 30px;
        }
        
        .student-name {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            margin: 20px 0;
            padding: 15px;
            border-bottom: 3px solid #764ba2;
            display: inline-block;
        }
        
        .course-name {
            font-size: 28px;
            color: #764ba2;
            font-weight: 600;
            margin: 20px 0;
        }
        
        .completion-date {
            font-size: 18px;
            color: #666;
            margin-top: 30px;
        }
        
        .certificate-footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .signature {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            border-top: 2px solid #333;
            margin-top: 60px;
            padding-top: 10px;
        }
        
        .signature-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        
        .signature-title {
            font-size: 14px;
            color: #666;
        }
        
        .certificate-number {
            position: absolute;
            bottom: 20px;
            left: 50px;
            font-size: 12px;
            color: #999;
        }
        
        .decorative-border {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 3px solid #667eea;
            border-radius: 10px;
            pointer-events: none;
        }
        
        .seal {
            position: absolute;
            top: 30px;
            right: 30px;
            width: 100px;
            height: 100px;
            border: 4px solid #764ba2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(102, 126, 234, 0.1);
        }
        
        .seal-text {
            font-size: 14px;
            font-weight: bold;
            color: #764ba2;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-inner">
            <div class="decorative-border"></div>
            
            <div class="seal">
                <div class="seal-text">
                    Certificate<br>Completion
                </div>
            </div>
            
            <div class="certificate-header">
                <h1 class="certificate-title">Certificate of Completion</h1>
                <p class="certificate-subtitle">Certificate of Course Completion</p>
            </div>
            
            <div class="certificate-body">
                <p class="certificate-text">
                    This certifies that
                </p>
                <div class="student-name">{{ $studentName }}</div>
                <p class="certificate-text">
                    has successfully completed the course
                </p>
                <div class="course-name">{{ $courseName }}</div>
                <p class="certificate-text">
                    on
                </p>
                <div class="completion-date">
                    {{ $completionDate }}
                </div>
            </div>
            
            <div class="certificate-footer">
                <div class="signature">
                    <div class="signature-line">
                            <div class="signature-name">{{ $instructorName ?? 'Director' }}</div>
                        <div class="signature-title">Instructor</div>
                    </div>
                </div>
                
                <div class="signature">
                    <div class="signature-line">
                        <div class="signature-name">Platform Management</div>
                        <div class="signature-title">Official Signature</div>
                    </div>
                </div>
            </div>
            
            <div class="certificate-number">
                Certificate Number: #{{ $certificateNumber }}
            </div>
        </div>
    </div>
</body>
</html>

