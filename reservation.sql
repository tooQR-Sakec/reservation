USE [reservation]
GO
/****** Object:  Table [dbo].[booking]    Script Date: 9/25/2020 4:05:07 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[booking](
	[bookingID] [int] IDENTITY(1,1) NOT NULL,
	[guestName] [varchar](50) NOT NULL,
	[guestEmail] [varchar](50) NOT NULL,
	[numberOfPeople] [int] NOT NULL,
	[roomID] [varchar](10) NULL,
	[startTime] [bigint] NOT NULL,
	[endTime] [bigint] NULL,
	[status] [varchar](15) NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[reserved]    Script Date: 9/25/2020 4:05:07 AM ******/
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
/****** Object:  Table [dbo].[settings]    Script Date: 9/25/2020 4:05:07 AM ******/
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
/****** Object:  Table [dbo].[tables]    Script Date: 9/25/2020 4:05:07 AM ******/
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
