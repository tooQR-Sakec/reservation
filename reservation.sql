USE [reservation]
GO
/****** Object:  Table [dbo].[booking]    Script Date: 9/25/2020 6:37:14 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[booking](
	[bookingID] [int] IDENTITY(1,1) NOT NULL,
	[guestName] [varchar](50) NOT NULL,
	[guestMobile] [varchar](50) NOT NULL,
	[numberOfPeople] [int] NOT NULL,
	[roomID] [varchar](10) NULL,
	[startTime] [bigint] NOT NULL,
	[endTime] [bigint] NULL,
	[status] [varchar](15) NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[reserved]    Script Date: 9/25/2020 6:37:14 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[reserved](
	[bookingID] [int] NOT NULL,
	[tableID] [int] NOT NULL,
	[startTime] [bigint] NOT NULL,
	[endTime] [bigint] NULL,
	[status] [varchar](15) NOT NULL,
 CONSTRAINT [PK_logs] PRIMARY KEY CLUSTERED 
(
	[bookingID] ASC,
	[status] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[settings]    Script Date: 9/25/2020 6:37:14 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[settings](
	[parameter] [varchar](25) NOT NULL,
	[value] [varchar](25) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[parameter] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tables]    Script Date: 9/25/2020 6:37:14 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tables](
	[tableID] [int] NOT NULL,
	[capacity] [int] NOT NULL,
	[blocked] [tinyint] NOT NULL,
 CONSTRAINT [PK_tables] PRIMARY KEY CLUSTERED 
(
	[tableID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'bookingPerDay', N'5')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'breakfast', N'3600')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'bufferTime', N'77')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'dinner', N'7200')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'fridayEnd', N'23:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'fridayStart', N'07:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'lunch', N'5400')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'mondayEnd', N'23:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'mondayStart', N'07:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'saturdayEnd', N'03:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'saturdayStart', N'10:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'sundayEnd', N'03:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'sundayStart', N'10:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'thursdayEnd', N'23:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'thursdayStart', N'07:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'tuesdayEnd', N'23:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'tuesdayStart', N'07:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'wednesdayEnd', N'23:00')
INSERT [dbo].[settings] ([parameter], [value]) VALUES (N'wednesdayStart', N'07:00')
GO
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (1, 2, 0)
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (2, 2, 0)
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (3, 2, 0)
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (4, 2, 0)
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (5, 2, 0)
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (6, 4, 0)
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (7, 4, 0)
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (8, 4, 0)
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (9, 4, 1)
INSERT [dbo].[tables] ([tableID], [capacity], [blocked]) VALUES (10, 7, 0)
GO
